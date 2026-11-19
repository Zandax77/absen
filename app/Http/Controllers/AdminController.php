<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Petugas;
use App\Models\Wali;
use App\Models\Siswa;
use App\Models\Absen;
use App\Models\Setting;

class AdminController extends Controller
{
    /**
     * Tampilkan formulir login admin
     */
    public function loginForm()
    {
        if (session('role') === 'admin') {
            return redirect('admin/dashboard');
        }
        return view('admin.login');
    }

    /**
     * Proses autentikasi admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'role' => 'admin',
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
            ]);

            return redirect('admin/dashboard')->with('success', 'Selamat datang kembali, Administrator!');
        }

        return redirect('admin/login')
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password admin salah!');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['role', 'admin_id', 'admin_username']);
        return redirect('admin/login')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Dashboard terpadu Admin
     */
    public function dashboard()
    {
        $petugas = Petugas::orderBy('created_at', 'desc')->get();
        $totalPetugas = $petugas->count();
        $petugasMenunggu = $petugas->where('status', 'menunggu')->count();
        $petugasDisetujui = $petugas->where('status', 'disetujui')->count();

        $walis = Wali::orderBy('kelas', 'asc')->get();
        $totalWali = $walis->count();
        $totalSiswa = Siswa::count();
        $totalAbsenHariIni = Absen::whereDate('created_at', date('Y-m-d'))->count();

        $currentSchoolName = Setting::get('school_name', 'SMKN 6 JEMBER');
        $currentSchoolLogo = Setting::get('school_logo', 'images/logo_smk6.png');
        $currentAppTitle   = Setting::get('app_title', 'Aplikasi Pencatat Kehadiran Siswa Kelas');

        return view('admin.dashboard', compact(
            'petugas',
            'totalPetugas',
            'petugasMenunggu',
            'petugasDisetujui',
            'walis',
            'totalWali',
            'totalSiswa',
            'totalAbsenHariIni',
            'currentSchoolName',
            'currentSchoolLogo',
            'currentAppTitle'
        ));
    }

    /**
     * Update Pengaturan Nama dan Logo Sekolah
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'app_title'   => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        Setting::set('school_name', $request->school_name);
        if ($request->filled('app_title')) {
            Setting::set('app_title', $request->app_title);
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $targetDir = public_path('uploads/logo');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $file->move($targetDir, $filename);

            Setting::set('school_logo', 'uploads/logo/' . $filename);
        }

        return back()->with('success', 'Pengaturan nama dan logo sekolah berhasil disimpan!');
    }

    /**
     * Parse baris data dari file yang diunggah (mendukung .xlsx, .xls, .csv, .txt)
     */
    private function parseRowsFromFile($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, ['xlsx', 'xls'])) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            return $sheet->toArray(null, true, true, false);
        } else {
            return array_map('str_getcsv', file($file->getRealPath()));
        }
    }

    /**
     * Import Wali data from an Excel (.xlsx/.xls) or CSV file.
     * Expected columns: kode,nama,kelas,sandi
     */
    public function importWali(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $request->file('file');
        $rows = $this->parseRowsFromFile($file);
        if (empty($rows)) {
            return back()->with('error', 'File yang diunggah kosong.');
        }

        $header = array_map('strtolower', array_map('trim', array_filter($rows[0])));
        $required = ['kode', 'nama', 'kelas', 'sandi'];
        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                return back()->with('error', "Kolom header wajib '$col' tidak ditemukan di file.");
            }
        }

        $inserted = 0;
        for ($i = 1; $i < count($rows); $i++) {
            $row = array_map('trim', $rows[$i]);
            if (count($row) < count($header) || empty($row[0])) continue;
            $data = array_combine($header, array_slice($row, 0, count($header)));
            $data['sandi'] = Hash::make($data['sandi']);
            
            Wali::updateOrCreate(['kode' => $data['kode']], $data);
            $inserted++;
        }

        return back()->with('success', "Berhasil mengimpor $inserted data wali kelas.");
    }

    /**
     * Import Siswa data from an Excel (.xlsx/.xls) or CSV file.
     * Expected columns: nis,nama,kelas,jk
     */
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $request->file('file');
        $rows = $this->parseRowsFromFile($file);
        if (empty($rows)) {
            return back()->with('error', 'File yang diunggah kosong.');
        }

        $header = array_map('strtolower', array_map('trim', array_filter($rows[0])));
        $required = ['nis', 'nama', 'kelas'];
        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                return back()->with('error', "Kolom header wajib '$col' tidak ditemukan di file.");
            }
        }

        $inserted = 0;
        for ($i = 1; $i < count($rows); $i++) {
            $row = array_map('trim', $rows[$i]);
            if (count($row) < count($header) || empty($row[0])) continue;
            $data = array_combine($header, array_slice($row, 0, count($header)));
            
            Siswa::updateOrCreate(['nis' => $data['nis']], $data);
            $inserted++;
        }

        return back()->with('success', "Berhasil mengimpor $inserted data siswa.");
    }

    /**
     * Unduh Template Excel (.xlsx) Siswa
     */
    public function downloadTemplateSiswaXlsx()
    {
        $file = public_path('templates/template_siswa.xlsx');
        if (!file_exists($file)) {
            abort(404, 'Template file tidak ditemukan.');
        }
        return response()->download($file, 'template_siswa.xlsx');
    }

    /**
     * Unduh Template Excel (.xlsx) Wali
     */
    public function downloadTemplateWaliXlsx()
    {
        $file = public_path('templates/template_wali.xlsx');
        if (!file_exists($file)) {
            abort(404, 'Template file tidak ditemukan.');
        }
        return response()->download($file, 'template_wali.xlsx');
    }

    /**
     * Unduh Template CSV Siswa
     */
    public function downloadTemplateSiswa()
    {
        $file = public_path('templates/template_siswa.csv');
        if (!file_exists($file)) {
            abort(404, 'Template file tidak ditemukan.');
        }
        return response()->download($file, 'template_siswa.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Unduh Template CSV Wali
     */
    public function downloadTemplateWali()
    {
        $file = public_path('templates/template_wali.csv');
        if (!file_exists($file)) {
            abort(404, 'Template file tidak ditemukan.');
        }
        return response()->download($file, 'template_wali.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
