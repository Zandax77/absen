<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Absen;
use App\Models\Wali;
use App\Models\Bk;
use App\Models\Kelas;



class Kendali extends Controller
{
    public function index(Request $request){
        if($request->session('opr')==""){
            return redirect('loginKelas');
        }
        else{
            return redirect('absenKelas');
        }
    }

    public function info(){
        return view('info');
    }

    public function loginKelas(){
        return view('loginKelas');
    }

    public function logout(Request $request){
        $request->session('opr')->flush();
        return redirect('');
    }

    public function prosesLoginKelas(Request $request){
        $user = $request->kode;
        $pass = $request->sandi;

        $data = Petugas::where('kode',md5($user))->where('sandi',md5($pass))->where('status','disetujui')->count();
        if($data>0){
            $data = Petugas::where('kode',md5($user))->where('sandi',md5($pass))->where('status','disetujui')->get();
                $petugas = $data[0]->nama;
                $kelas = $data[0]->kelas;
                $request->session()->put('opr',$petugas);
                $request->session()->put('kelas',$kelas);
                return redirect('absenKelas');
        }
        else{
            return view('gagalLogin');
        }

    }

    public function regPetugasKelas(){
        $data = Siswa::select('kelas')->groupby('kelas')->get();
        return view('regPetugasKelas',['kelas'=>$data]);
    }

    public function simpanPetugasKelas(Request $request){
        $nama = $request->nama;
        $kelas = $request->kelas;
        $kode = md5($request->kode);
        $sandi= md5($request->sandi);

        Petugas::create([
            'nama'=>$nama,
            'kelas'=>$kelas,
            'kode'=>$kode,
            'sandi'=>$sandi,
            'status'=>'menunggu'
        ]);
        return view('hasilRegPetugasKelas');
    }

	public function operator(){
    	$data = Petugas::all();
    	return view('operator',['data'=>$data]);
    }

	public function setujuiUser($kode){
        $x = 'disetujui';
        Petugas::where('kode',$kode)->update(['status'=>$x]);
        return redirect('operator');
    }

    public function blokirUser($kode){
        $x = 'menunggu';
        Petugas::where('kode',$kode)->update(['status'=>$x]);
        return redirect('operator');
    }

    public function hapusUser($kode){
        Petugas::where('kode',$kode)->delete();
        return redirect('operator');
    }



    public function absenKelas(Request $request){
    	date_default_timezone_set('Asia/Jakarta');
        $opr = $request->session()->get('opr');
        $kelas = $request->session()->get('kelas');

        if($opr!=""&&$kelas!=""){
            $data = Siswa::where('kelas',$kelas)->get();
            $tgl = date('d/m/Y');
            $absen = Absen::where('tgl',$tgl)->where('absens.kelas',$kelas)
                ->join('siswas', 'siswas.nis','=','absens.nis')
                ->select('siswas.nama','absens.ket')
                ->get();
            return view('absenKelas',['data'=>$data],['absen'=>$absen]);
        }else{
            return redirect('loginKelas');
        }

    }

    public function simpanAbsenKelas(Request $request){
    	date_default_timezone_set('Asia/Jakarta');
        $tgl = $request->tgl;
        $kelas = $request->kelas;
        $nis = $request->nis;
        $ket = $request->ket;
        $opr = $request->session()->get('opr');

        if($nis==''){
            return redirect('absenKelas');
        }
        $data = Absen::where('nis',$nis)->where('tgl',$tgl)->count();
    	if($data==0){
        	Absen::create([
            'tgl'=>$tgl,
            'kelas'=>$kelas,
            'nis'=>$nis,
            'ket'=>$ket,
            'opr'=>$opr
        	]);
        	
        return redirect('absenKelas');
        }else{
        	echo "Siswa tersebut telah tercatat, jika terjadi salah catat hubungi <b>walikelas</b> untuk perbaikan";        	
        }
    	
    }

	public function updateAbsen(Request $request,$id){
        $ket = $request->ket;
        Absen::where('id',$id)->update(['ket'=>$ket]);
        return view('infoWali');
    }


    public function simpanAbsenKelasWali(Request $request){
        $tgl = $request->tgl;
        $kelas = $request->kelas;
        $nis = $request->nis;
        $ket = $request->ket;
        $opr = $request->session()->get('opr');

		if($nis==''){
            return redirect('infoWali');
        }
		 $data = Absen::where('nis',$nis)->where('tgl',$tgl)->count();
    	if($data==0){
        	Absen::create([
            'tgl'=>$tgl,
            'kelas'=>$kelas,
            'nis'=>$nis,
            'ket'=>$ket,
            'opr'=>$opr
        	]);
        return redirect('infoWali');
        }else{
        	echo "<center>Siswa tersebut telah tercatat, periksa kembali untuk perbaikan</center>";        	
        }        
    
    }

    //walikelas

    public function loginWali(){
        return view('loginWaliKelas');
    }

    public function prosesLoginWali(Request $request){
        $user = $request->kode;
        $pass = $request->sandi;

        echo md5($user);

        $data = Wali::where('kode',md5($user))->where('sandi',md5($pass))->count();
        if($data>0){
            $data = Wali::where('kode',md5($user))->where('sandi',md5($pass))->get();
                $petugas = $data[0]->nama;
                $kelas = $data[0]->kelas;
                $request->session()->put('opr',$petugas);
                $request->session()->put('kelas',$kelas);
                return redirect('infoWali');
        }
        else{
            return view('gagalLoginWali');
        }
    }

    public function logoutWali(Request $request){
        $request->session()->flush();
        return redirect('wali');
    }

    public function regWali(){
        $data = Siswa::select('kelas')->groupby('kelas')->get();
        return view('regWaliKelas',['kelas'=>$data]);
    }

    public function simpanWali(Request $request){
        $nama = $request->nama;
        $kelas = $request->kelas;
        $kode = md5($request->kode);
        $sandi = md5($request->sandi);

        Wali::create([
            'kode'=>$kode,
            'nama'=>$nama,
            'kelas'=>$kelas,
            'sandi'=>$sandi,
        ]);
        return view('hasilRegWali');
    }

	public function dataWali(){
        $data = Wali::all();
        return view('dataWali',['data'=>$data]);
    }

    public function infoWali(Request $request){
    	date_default_timezone_set('Asia/Jakarta');
        $kelas = $request->session()->get('kelas');
        $tgl = date('d/m/Y');
        $data = Absen::where('absens.kelas',$kelas)->where('tgl',$tgl)
            ->join('siswas','siswas.nis','=','absens.nis')
            ->select('absens.id','siswas.nama','absens.ket')
            ->get();

        $siswa = Siswa::where('kelas',$kelas)->get();
        
        if($request->session('opr')==""){
            return redirect('wali');
         }
        else{
            //return redirect('absenKelas');
            return view('infoWali',['absen'=>$data,'data'=>$siswa]);
        }

        
    }

    public function hapusAbsen(Request $request,$id){
        $opr = $request->session()->get('opr');
        //$id = $request->id;
        $kelas = $request->session()->get('kelas');

        Absen::where('id',$id)->where('kelas',$kelas)->delete();
        return redirect('infoWali');
    }

    public function editAbsen($id){
        $data = Absen::where('id',$id)->get();
        return view('editAbsen',['data'=>$data]);
    }

    public function ubahAbsen(Request $request,$id){
        $id = $request->$id;
        $ket = $request->ket;
        Absen::where('id',$id)->update([
            'ket'=>$ket
        ]);
        return redirect('absenKelas/infoWali');
    }

    //rekap absen
    //rekap harian
    public function rekapHarian(){
    	date_default_timezone_set('Asia/Jakarta');
        $sekarang = date('d/m/Y');
        
        
        //$nihil = request()->input('nihil');
        $nihil = 0;

        //kelas X RPL
        $XRPL = Siswa::where('kelas','like','XRP'.'%')->count();
        $xRPLa = Absen::where('kelas','like','XRP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xRPLs = Absen::where('kelas','like','XRP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xRPLi = Absen::where('kelas','like','XRP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xRPLa>0||$xRPLs>0||$xRPLi>0){
            $XRPL_hadir = $XRPL-($xRPLa+$xRPLi+$xRPLs);    
        }else{
            $XRPL_hadir = 0;
        }
        
        //kelas X DKV
        $xDKV = Siswa::where('kelas','like','XDKV'.'%')->count();
        $xDKVa = Absen::where('kelas','like','XDK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xDKVs = Absen::where('kelas','like','XDK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xDKVi = Absen::where('kelas','like','XDK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xDKVa>0||$xDKVs>0||$xDKVi>0){
            $XDKV_hadir = $xDKV-($xDKVa+$xDKVi+$xDKVs);    
        }else{
            $XDKV_hadir = 0;
        }
        

        //kelas X KKBT
        $XKKBT = Siswa::where('kelas','like','XKK'.'%')->count();
        $xKKBTa = Absen::where('kelas','like','XKK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xKKBTs = Absen::where('kelas','like','XKK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xKKBTi = Absen::where('kelas','like','XKK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xKKBTa>0||$xKKBTs>0||$xKKBTi>0){
            $XKKBT_hadir = $XKKBT-($xKKBTa+$xKKBTi+$xKKBTs);    
        }else{
            $XKKBT_hadir = 0;
        }
        

        //kelas X MP
        $XMP = Siswa::where('kelas','like','XMP'.'%')->count();
        $xMPa = Absen::where('kelas','like','XMP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xMPs = Absen::where('kelas','like','XMP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xMPi = Absen::where('kelas','like','XMP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xMPa>0||$xMPs>0||$xMPi>0){
            $XMP_hadir = $XMP-($xMPa+$xMPi+$xMPs);    
        }else{
            $XMP_hadir = 0;
        }
        

        //kelas X BD
        $XBD= Siswa::where('kelas','like','XBD'.'%')->count();
        $xBDa = Absen::where('kelas','like','XBD'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xBDs = Absen::where('kelas','like','XBD'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xBDi = Absen::where('kelas','like','XBD'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xBDa>0||$xBDs>0||$xBDi>0){
            $XBD_hadir = $XBD-($xBDa+$xBDi+$xBDs);    
        }else{
            $XBD_hadir = 0;
        }
        

        //kelas X AK
        $XAK = Siswa::where('kelas','like','XAK'.'%')->count();
        $xAKa = Absen::where('kelas','like','XAK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xAKs = Absen::where('kelas','like','XAK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xAKi = Absen::where('kelas','like','XAK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xAKa>0||$xAKs>0||$xAKi>0){
            $XAK_hadir = $XAK-($xAKa+$xAKi+$xAKs);    
        }else{
            $XAK_hadir = 0;
        }
        

        //kelas XI

         //kelas XI RPL
         $XIRPL = Siswa::where('kelas','like','XIRP'.'%')->count();
         $xiRPLa = Absen::where('kelas','like','XIRP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiRPLs = Absen::where('kelas','like','XIRP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiRPLi = Absen::where('kelas','like','XIRP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         if($nihil==1||$xiRPLa>0||$xiRPLs>0||$xiRPLi>0){
            $XIRPL_hadir = $XIRPL-($xiRPLa+$xiRPLi+$xiRPLs);    
         }else{
            $XIRPL_hadir = 0;
         }
         

         //kelas XI DKV
         $XIDKV = Siswa::where('kelas','like','XIDKV'.'%')->count();
         $xiDKVa = Absen::where('kelas','like','XIDK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiDKVs = Absen::where('kelas','like','XIDK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiDKVi = Absen::where('kelas','like','XIDK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         if($nihil==1||$xiDKVa>0||$xiDKVs>0||$xiDKVi>0){
            $XIDKV_hadir = $XIDKV-($xiDKVa+$xiDKVi+$xiDKVs);    
         }else{
             $XIDKV_hadir = 0;
         }
         

         //kelas XI KKBT
         $xiKKBT = Siswa::where('kelas','like','XIKK'.'%')->count();
         $xiKKBTa = Absen::where('kelas','like','XIKK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiKKBTs = Absen::where('kelas','like','XIKK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiKKBTi = Absen::where('kelas','like','XIKK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         $nihil = 0;
         if($nihil==1||$xiKKBTa>0||$xiKKBTs>0||$xiKKBTi>0){
            $xiKKBT_hadir = $xiKKBT-($xiKKBTa+$xiKKBTi+$xiKKBTs);    
         }else{
            $xiKKBT_hadir = 0;
         }
         

         //kelas XI MP
         $XIMP = Siswa::where('kelas','like','XIMP'.'%')->count();
         $xiMPa = Absen::where('kelas','like','XIMP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiMPs = Absen::where('kelas','like','XIMP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiMPi = Absen::where('kelas','like','XIMP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         if($nihil==1|| $xiMPa>0||$xiMPs>0||$xiMPi>0){
            $XIMP_hadir = $XIMP-($xiMPa+$xiMPi+$xiMPs);    
         }else{
            $XIMP_hadir = 0;
         }
         

         //kelas XI BD
         $XIBD= Siswa::where('kelas','like','XIBD'.'%')->count();
         $xiBDa = Absen::where('kelas','like','XIBD'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiBDs = Absen::where('kelas','like','XIBD'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiBDi = Absen::where('kelas','like','XIBD'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         if($nihil==1||$xiBDa>0||$xiBDs>0||$xiBDi>0){
            $XIBD_hadir = $XIBD-($xiBDa+$xiBDi+$xiBDs);    
         }else{
            $XIBD_hadir = 0;
         }
         

         //kelas XI AK
         $XIAK = Siswa::where('kelas','like','XIAK'.'%')->count();
         $xiAKa = Absen::where('kelas','like','XIAK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
         $xiAKs = Absen::where('kelas','like','XIAK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
         $xiAKi = Absen::where('kelas','like','XIAK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

         //$nihil = 0;
         if($nihil==1||$xiAKa>0||$xiAKs>0||$xiAKi>0){
            $XIAK_hadir = $XIAK-($xiAKa+$xiAKi+$xiAKs);    
         }else{
            $XIAK_hadir = 0;
         }
         


         //kelas XII

          //kelas XII RPL
        $XIIRPL = Siswa::where('kelas','like','XIIRP'.'%')->count();
        $xiiRPLa = Absen::where('kelas','like','XIIRP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiRPLs = Absen::where('kelas','like','XIIRP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiRPLi = Absen::where('kelas','like','XIIRP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        $nihil = 0;
        if($nihil==1||$xiiRPLa>0||$xiiRPLi>0||$xiiRPLs>0){
            $XIIRPL_hadir = $XIIRPL-($xiiRPLa+$xiiRPLi+$xiiRPLs);
        }
        else{
            $XIIRPL_hadir = 0;
        }

        //kelas XII DKV
        $XIIDKV = Siswa::where('kelas','like','XIIDKV'.'%')->count();
        $xiiDKVa = Absen::where('kelas','like','XIIDKV'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiDKVs = Absen::where('kelas','like','XIIDKV'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiDKVi = Absen::where('kelas','like','XIIDKV'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xiiDKVa>0||$xiiDKVs>0||$xiiDKVi>0){
            $XIIDKV_hadir = $XIIDKV-($xiiDKVa+$xiiDKVi+$xiiDKVs);    
        }else{
            $XIIDKV_hadir = 0;
        }
        

        //kelas XII KKBT
        $XIIKKBT = Siswa::where('kelas','like','XIIKK'.'%')->count();
        $xiiKKBTa = Absen::where('kelas','like','XIIKK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiKKBTs = Absen::where('kelas','like','XIIKK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiKKBTi = Absen::where('kelas','like','XIIKK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        $nihil = 0;
        if($nihil==1){
            $XIIKKBT_hadir = $XIIKKBT-($xiiKKBTa+$xiiKKBTi+$xiiKKBTs);
        }else{
            $XIIKKBT_hadir = 0;
        }
                
        
        
        

        //kelas XII MP/OTKP
        $XIIMP = Siswa::where('kelas','like','XIIMP'.'%')->count();
        $xiiMPa = Absen::where('kelas','like','XIIMP'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiMPs = Absen::where('kelas','like','XIIMP'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiMPi = Absen::where('kelas','like','XIIMP'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xiiMPa>0||$xiiMPs>0||$xiiMPi>0){
            $XIIMP_hadir = $XIIMP-($xiiMPa+$xiiMPi+$xiiMPs);    
        }else{
            $XIIMP_hadir = 0;
        }
        

        //kelas XII BDP
        $XIIBD= Siswa::where('kelas','like','XIIBD'.'%')->count();
        $xiiBDa = Absen::where('kelas','like','XIIBD'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiBDs = Absen::where('kelas','like','XIIBD'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiBDi = Absen::where('kelas','like','XIIBD'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xiiBDa>0||$xiiBDs>0||$xiiBDi>0){
            $XIIBD_hadir = $XIIBD-($xiiBDa+$xiiBDi+$xiiBDs);    
        }else{
            $XIIBD_hadir = 0;
        }
        

        //kelas XII AKL
        $XIIAK = Siswa::where('kelas','like','XIIAK'.'%')->count();
        $xiiAKa = Absen::where('kelas','like','XIIAK'.'%')->where('ket','A')->where('tgl',$sekarang)->count();
        $xiiAKs = Absen::where('kelas','like','XIIAK'.'%')->where('ket','S')->where('tgl',$sekarang)->count();
        $xiiAKi = Absen::where('kelas','like','XIIAK'.'%')->where('ket','I')->where('tgl',$sekarang)->count();

        if($nihil==1||$xiiAKa>0||$xiiAKs>0||$xiiAKi>0){
            $XIIAK_hadir = $XIIAK-($xiiAKa+$xiiAKi+$xiiAKs);    
        }else{
            $XIIAK_hadir = 0;
        }
        

        $siswa = Siswa::count();
        $totalAlpa = Absen::where('ket','A')->where('tgl',$sekarang)->count();
        $totalIzin = Absen::where('ket','I')->where('tgl',$sekarang)->count();
        $totalSakit = Absen::where('ket','S')->where('tgl',$sekarang)->count();
        
        //$totalHadir = $siswa-($totalAlpa+$totalIzin+$totalSakit);
        $totalHadir = $XRPL_hadir+$XDKV_hadir+$XAK_hadir+$XMP_hadir+$XBD_hadir+$XKKBT_hadir+$XIRPL_hadir+$XIDKV_hadir+$XIAK_hadir+$XIMP_hadir+$XIBD_hadir+$xiKKBT_hadir+$XIIRPL_hadir+$XIIDKV_hadir+$XIIAK_hadir+$XIIMP_hadir+$XIIBD_hadir+$XIIKKBT_hadir;

        return view('info',[
            'xrpl'=>$XRPL_hadir,'xrplA'=>$xRPLa,'xrplI'=>$xRPLi,'xrplS'=>$xRPLs,
            'xdkv'=>$XDKV_hadir,'xdkvA'=>$xDKVa,'xdkvI'=>$xDKVi,'xdkvS'=>$xDKVs,
            'xkkbt'=>$XKKBT_hadir,'xkkbtA'=>$xKKBTa,'xkkbtI'=>$xKKBTi,'xkkbtS'=>$xKKBTs,
            'xmp'=>$XMP_hadir,'xmpA'=>$xMPa,'xmpI'=>$xMPi,'xmpS'=>$xMPs,
            'xbd'=>$XBD_hadir,'xbdA'=>$xBDa,'xbdI'=>$xBDi,'xbdS'=>$xBDs,
            'xak'=>$XAK_hadir,'xakA'=>$xAKa,'xakI'=>$xAKi,'xakS'=>$xAKs,
            'xirpl'=>$XIRPL_hadir,'xirplA'=>$xiRPLa,'xirplI'=>$xiRPLi,'xirplS'=>$xiRPLs,
            'xidkv'=>$XIDKV_hadir,'xidkvA'=>$xiDKVa,'xidkvI'=>$xDKVi,'xidkvS'=>$xiDKVs,
            'xikkbt'=>$xiKKBT_hadir,'xikkbtA'=>$xiKKBTa,'xikkbtI'=>$xiKKBTi,'xikkbtS'=>$xiKKBTs,
            'ximp'=>$XIMP_hadir,'ximpA'=>$xMPa,'ximpI'=>$xiMPi,'ximpS'=>$xiMPs,
            'xibd'=>$XIBD_hadir,'xibdA'=>$xiBDa,'xibdI'=>$xiBDi,'xibdS'=>$xiBDs,
            'xiak'=>$XIAK_hadir,'xiakA'=>$xiAKa,'xiakI'=>$xiAKi,'xiakS'=>$xiAKs,
            'xiirpl'=>$XIIRPL_hadir,'xiirplA'=>$xiiRPLa,'xiirplI'=>$xiiRPLi,'xiirplS'=>$xiiRPLs,
            'xiiDKV'=>$XIIDKV_hadir,'xiiDKVA'=>$xiiDKVa,'xiiDKVI'=>$xiiDKVi,'xiiDKVS'=>$xiiDKVs,
            'xiikkbt'=>$XIIKKBT_hadir,'xiikkbtA'=>$xiiKKBTa,'xiikkbtI'=>$xiiKKBTi,'xiikkbtS'=>$xiiKKBTs,
            'xiimp'=>$XIIMP_hadir,'xiimpA'=>$xiiMPa,'xiimpI'=>$xiiMPi,'xiimpS'=>$xiiMPs,
            'xiibd'=>$XIIBD_hadir,'xiibdA'=>$xiiBDa,'xiibdI'=>$xiiBDi,'xiibdS'=>$xiiBDs,
            'xiiak'=>$XIIAK_hadir,'xiiakA'=>$xiiAKa,'xiiakI'=>$xiiAKi,'xiiakS'=>$xiiAKs,
            //'xiiot'=>$XIIOT_hadir,'xiiotA'=>$xiiOTa,'xiiotI'=>$xiiOTi,'xiiotS'=>$xiiOTs,
            'xbd'=>$XBD_hadir,'xbdA'=>$xBDa,'xbdI',$xBDi,'xbdS'=>$xBDs,
            'hadir'=>$totalHadir,
            'S'=>$totalSakit,
            'I'=>$totalIzin,
            'A'=>$totalAlpa
        ]);

    }

	public function detailAbsen(){
         date_default_timezone_set('Asia/Jakarta');
        $sekarang = date('d/m/Y');
        $data = Absen::join('siswas','siswas.nis','=','absens.nis')
            ->select('siswas.nama','siswas.kelas','absens.ket','absens.opr')->orderBy('absens.kelas','asc')
            ->where('absens.tgl',$sekarang)
            ->get();
            return view('generalAbsen',['data'=>$data]);
    }
    
}
