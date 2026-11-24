<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Kendali;

// Home & Umum
Route::get('', [Kendali::class, 'index']);
Route::get('logout', [Kendali::class, 'logout']);
Route::get('info', [Kendali::class, 'info']);
Route::redirect('rekapAbsen', '/rekapAbsen/');

// Petugas Absensi Kelas
Route::get('loginKelas', [Kendali::class, 'loginKelas']);
Route::post('prosesLoginKelas', [Kendali::class, 'prosesLoginKelas']);
Route::get('regPetugasKelas', [Kendali::class, 'regPetugasKelas']);
Route::post('simpanPetugasKelas', [Kendali::class, 'simpanPetugasKelas']);
Route::get('absenKelas', [Kendali::class, 'absenKelas']);
Route::post('simpanAbsenKelas', [Kendali::class, 'simpanAbsenKelas']);

// Wali Kelas
Route::get('wali', [Kendali::class, 'loginWali']);
Route::post('prosesLoginWali', [Kendali::class, 'prosesLoginWali']);
Route::get('logoutWali', [Kendali::class, 'logoutWali']);
Route::get('regWaliKelas', [Kendali::class, 'regWali']);
Route::post('simpanWali', [Kendali::class, 'simpanWali']);
Route::get('dataWali', [Kendali::class, 'dataWali']);
Route::get('infoWali', [Kendali::class, 'infoWali']);
Route::post('simpanAbsenKelasWali', [Kendali::class, 'simpanAbsenKelasWali']);
Route::get('hapusAbsen/{id}', [Kendali::class, 'hapusAbsen']);
Route::get('editAbsen/{id}', [Kendali::class, 'editAbsen']);
Route::post('updateAbsen/{id}', [Kendali::class, 'ubahAbsen']);

// Rekap Harian
Route::post('rekapHarian', [Kendali::class, 'rekapHarian']);
Route::get('rekapHarian', [Kendali::class, 'rekapHarian']);
Route::get('generalAbsen', [Kendali::class, 'detailAbsen']);

// Autentikasi Admin (Guest)
Route::get('admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('admin/logout', [AdminController::class, 'logout']);

// Area Khusus Administrator (Protected Middleware)
Route::middleware(['admin'])->group(function () {
    Route::get('admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);

    // Persetujuan & Manajemen Petugas Kelas
    Route::get('operator', [Kendali::class, 'operator'])->name('admin.operator');
    Route::get('setujui/{kode}', [Kendali::class, 'setujuiUser']);
    Route::get('blokir/{kode}', [Kendali::class, 'blokirUser']);
    Route::get('hapus/{kode}', [Kendali::class, 'hapusUser']);

    // Manajemen Siswa (CRUD)
    Route::post('admin/siswa', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::post('admin/siswa/{id}/update', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::get('admin/siswa/{id}/delete', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');
    Route::post('admin/siswa/delete-all', [AdminController::class, 'destroyAllSiswa'])->name('admin.siswa.destroyAll');

    // Import Data & Unduh Template (Excel & CSV)
    Route::post('admin/wali/import', [AdminController::class, 'importWali']);
    Route::post('admin/siswa/import', [AdminController::class, 'importSiswa']);
    Route::get('admin/template/siswa/xlsx', [AdminController::class, 'downloadTemplateSiswaXlsx'])->name('admin.template.siswa.xlsx');
    Route::get('admin/template/wali/xlsx', [AdminController::class, 'downloadTemplateWaliXlsx'])->name('admin.template.wali.xlsx');
    Route::get('admin/template/siswa', [AdminController::class, 'downloadTemplateSiswa'])->name('admin.template.siswa');
    Route::get('admin/template/wali', [AdminController::class, 'downloadTemplateWali'])->name('admin.template.wali');
    // Pengaturan Nama & Logo Sekolah
    Route::post('admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});
