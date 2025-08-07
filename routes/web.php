<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kendali;

Route::get('',[Kendali::class,'index']);
Route::get('logout',[Kendali::class,'logout']);
Route::get('absenKelas',[Kendali::class,'absenKelas']);
Route::post('simpanAbsenKelas',[Kendali::class,'simpanAbsenKelas']);
Route::post('simpanAbsenKelasWali',[Kendali::class,'simpanAbsenKelasWali']);
Route::get('loginKelas',[Kendali::class,'loginKelas']);
Route::post('prosesLoginKelas',[Kendali::class,'prosesLoginKelas']);
Route::get('regPetugasKelas',[Kendali::class,'regPetugasKelas']);
Route::post('simpanPetugasKelas',[Kendali::class,'simpanPetugasKelas']);
Route::get('operator',[Kendali::class,'operator']);
Route::get('setujui/{kode}',[Kendali::class,'setujuiUser']);
Route::get('blokir/{kode}',[Kendali::class,'blokirUser']);
Route::get('hapus/{kode}',[Kendali::class,'hapusUser']);



//waliKelas
Route::get('dataWali',[Kendali::class,'dataWali']);
Route::get('wali',[Kendali::class,'loginWali']);
Route::get('logoutWali',[Kendali::class,'logoutWali']);
Route::get('logout',[Kendali::class,'logout']);
Route::post('prosesLoginWali',[Kendali::class,'prosesLoginWali']);
Route::get('regWaliKelas',[Kendali::class,'regWali']);
Route::post('simpanWali',[Kendali::class,'simpanWali']);
Route::get('infoWali',[Kendali::class,'infoWali']);
Route::get('hapusAbsen/{id}',[Kendali::class,'hapusAbsen']);
Route::get('editAbsen/{id}',[Kendali::class,'editAbsen']);
Route::post('updateAbsen/{id}',[Kendali::class,'ubahAbsen']);

Route::get('info',[Kendali::class,'info']);

Route::get('rekapHarian',[Kendali::class,'rekapHarian']);
Route::get('generalAbsen',[Kendali::class,'detailAbsen']);
