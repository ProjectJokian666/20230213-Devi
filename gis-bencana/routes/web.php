<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenController as Authen;

use App\Http\Controllers\DashboardController as Dashboard;

use App\Http\Controllers\AdminController as Admin;
use App\Http\Controllers\Admin\PetugasController as AdminPetugas;
use App\Http\Controllers\Admin\WilayahController as AdminWilayah;
use App\Http\Controllers\Admin\BencanaController as AdminBencana;
use App\Http\Controllers\Admin\DataController as Admindata;
use App\Http\Controllers\Admin\BencanaPerWilayahController as AdminBencanaPerWilayah;
use App\Http\Controllers\Admin\SetWilayahBencanaController as AdminSetWilayahBencana;

use App\Http\Controllers\PetugasController as Petugas;
use App\Http\Controllers\Petugas\WilayahController as PetugasWilayah;
use App\Http\Controllers\Petugas\BencanaController as PetugasBencana;
use App\Http\Controllers\Petugas\DataController as Petugasdata;
use App\Http\Controllers\Petugas\SetWilayahBencanaController as PetugasSetWilayahBencana;


use App\Http\Controllers\Guest\PetaController as Peta;
use App\Http\Controllers\Guest\DataController as GuestData;
use App\Http\Controllers\Guest\GrafikController as Grafik;
use App\Http\Controllers\Guest\InformasiController as Informasi;

Route::get('/',[Dashboard::class,'index'])->name('index');
Route::get('get_maps',[Dashboard::class,'get_maps'])->name('get_maps');
Route::get('get_maps_fix',[Dashboard::class,'get_maps_fix'])->name('get_maps_fix');

Route::prefix('peta')->name('peta.')->group(function(){
    Route::get('',[Peta::class,'peta'])->name('peta');
    Route::get('get_peta',[Peta::class,'get_peta'])->name('get_peta');
});
Route::prefix('grafik')->name('grafik.')->group(function(){
    Route::get('',[Grafik::class,'grafik'])->name('grafik');
    Route::get('get_bencana',[Grafik::class,'get_bencana'])->name('get_bencana');
    Route::get('get_terjadi',[Grafik::class,'get_terjadi'])->name('get_terjadi');
});
Route::prefix('informasi')->name('informasi.')->group(function(){
    Route::get('',[Informasi::class,'informasi'])->name('informasi');
    Route::get('get_auto_gempa',[Informasi::class,'get_auto_gempa'])->name('get_auto_gempa');
});

Route::middleware('guest')->group(function(){
    Route::get('login',[Authen::class,'login'])->name('login');
    Route::post('login',[Authen::class,'plogin'])->name('plogin');

    Route::prefix('data')->name('data')->group(function(){
        Route::get('',[GuestData::class,'data']);
        Route::get('detail/{id}',[GuestData::class,'detail'])->name('.detail');

        Route::get('wilayah_by_bencana',[GuestData::class,'wilayah_by_bencana'])->name('.wilayah_by_bencana');
        Route::get('tahun_by_wilayah_by_bencana',[GuestData::class,'tahun_by_wilayah_by_bencana'])->name('.tahun_by_wilayah_by_bencana');
        Route::get('data_tahun_by_wilayah_by_bencana',[GuestData::class,'data_tahun_by_wilayah_by_bencana'])->name('.data_tahun_by_wilayah_by_bencana');

        Route::get('show_wilayah_by_bencana',[GuestData::class,'show_wilayah_by_bencana'])->name('.show_wilayah_by_bencana');
        Route::get('show_tahun_by_wilayah_by_bencana',[GuestData::class,'show_tahun_by_wilayah_by_bencana'])->name('.show_tahun_by_wilayah_by_bencana');
        Route::get('show_data_tahun_by_wilayah_by_bencana',[GuestData::class,'show_data_tahun_by_wilayah_by_bencana'])->name('.show_data_tahun_by_wilayah_by_bencana');

    });
});

Route::middleware('auth')->group(function(){
    Route::get('logout',[Authen::class,'logout'])->name('logout');

    Route::get('profil',[Authen::class,'profil'])->name('profil');
    Route::post('profil',[Authen::class,'pprofil'])->name('pprofil');
    Route::post('profil_img',[Authen::class,'pprofil_img'])->name('pprofil_img');

    Route::prefix('admin')->name('admin')->group(function(){
        Route::get('',[Admin::class,'admin'])->name('.admin');
        Route::get('get_maps',[Admin::class,'get_maps'])->name('.get_maps');

        Route::get('petugas',[AdminPetugas::class,'petugas'])->name('.petugas');
        Route::post('add_petugas',[AdminPetugas::class,'add_petugas'])->name('.add_petugas');
        Route::patch('update_petugas',[AdminPetugas::class,'update_petugas'])->name('.update_petugas');
        Route::delete('delete_petugas',[AdminPetugas::class,'delete_petugas'])->name('.delete_petugas');

        Route::prefix('bencana')->name('.bencana')->group(function(){
            Route::get('',[AdminBencana::class,'bencana']);

            Route::get('wilayah/{id}',[AdminBencana::class,'wilayah'])->name('.wilayah');
            Route::post('wilayah/{id}',[AdminBencana::class,'add_wilayah'])->name('.add_wilayah');
            Route::patch('wilayah/{id}',[AdminBencana::class,'patch_wilayah'])->name('.patch_wilayah');
            Route::delete('wilayah/{id}',[AdminBencana::class,'delete_wilayah'])->name('.delete_wilayah');
        });
        
        Route::prefix('setwilayahbencana')->name('.setwilayahbencana')->group(function(){
            Route::get('',[AdminSetWilayahBencana::class,'index'])->name('.index');
            Route::get('show_data',[AdminSetWilayahBencana::class,'show_data'])->name('.show_data');
            Route::post('post_data',[AdminSetWilayahBencana::class,'post_data'])->name('.post_data');
            Route::patch('update_data',[AdminSetWilayahBencana::class,'update_data'])->name('.update_data');
            Route::delete('delete_data',[AdminSetWilayahBencana::class,'delete_data'])->name('.delete_data');

        });

        Route::prefix('data')->name('.data')->group(function(){
            Route::get('',[AdminData::class,'data']);
            Route::get('detail/{id}',[AdminData::class,'detail'])->name('.detail');


            Route::get('wilayah_by_bencana',[AdminData::class,'wilayah_by_bencana'])->name('.wilayah_by_bencana');
            Route::get('tahun_by_wilayah_by_bencana',[AdminData::class,'tahun_by_wilayah_by_bencana'])->name('.tahun_by_wilayah_by_bencana');
            Route::get('data_tahun_by_wilayah_by_bencana',[AdminData::class,'data_tahun_by_wilayah_by_bencana'])->name('.data_tahun_by_wilayah_by_bencana');

            Route::get('show_wilayah_by_bencana',[AdminData::class,'show_wilayah_by_bencana'])->name('.show_wilayah_by_bencana');
            Route::get('show_tahun_by_wilayah_by_bencana',[AdminData::class,'show_tahun_by_wilayah_by_bencana'])->name('.show_tahun_by_wilayah_by_bencana');
            Route::get('show_data_tahun_by_wilayah_by_bencana',[AdminData::class,'show_data_tahun_by_wilayah_by_bencana'])->name('.show_data_tahun_by_wilayah_by_bencana');

        });

        Route::post('add_bencana',[AdminBencana::class,'add_bencana'])->name('.add_bencana');
        Route::patch('update_bencana',[AdminBencana::class,'update_bencana'])->name('.update_bencana');
        Route::delete('delete_bencana',[AdminBencana::class,'delete_bencana'])->name('.delete_bencana');

        Route::get('wilayah',[AdminWilayah::class,'wilayah'])->name('.wilayah');
        Route::post('add_wilayah',[AdminWilayah::class,'add_wilayah'])->name('.add_wilayah');
        Route::patch('update_wilayah',[AdminWilayah::class,'update_wilayah'])->name('.update_wilayah');
        Route::delete('delete_wilayah',[AdminWilayah::class,'delete_wilayah'])->name('.delete_wilayah');

        Route::get('add_wilayah',[AdminWilayah::class,'create_wilayah'])->name('.create_wilayah');
        Route::get('post_file',[AdminWilayah::class,'post_file'])->name('.post_file');
        Route::post('post_file',[AdminWilayah::class,'data_post_file'])->name('.data_post_file');
        Route::get('cek_file',[AdminWilayah::class,'cek_file'])->name('.cek_file');
    });

    Route::prefix('petugas')->name('petugas')->group(function(){
        Route::get('',[Petugas::class,'petugas']);
        Route::get('get_maps',[Petugas::class,'get_maps'])->name('.get_maps');

        Route::prefix('bencana')->name('.bencana')->group(function(){
            Route::get('',[PetugasBencana::class,'bencana']);
            Route::get('{id}/delete',[PetugasBencana::class,'delete_bencana']);

            Route::get('wilayah/{id}',[PetugasBencana::class,'wilayah'])->name('.wilayah');
            Route::post('wilayah/{id}',[PetugasBencana::class,'show_wilayah'])->name('.show_wilayah');
            Route::patch('wilayah/{id}',[PetugasBencana::class,'update_wilayah'])->name('.update_wilayah');
            Route::patch('wilayah/{id}/ubah',[PetugasBencana::class,'ubah_wilayah'])->name('.ubah_wilayah');
            Route::delete('wilayah/{id}',[PetugasBencana::class,'delete_wilayah'])->name('.delete_wilayah');

        });

        Route::prefix('data')->name('.data')->group(function(){
            Route::get('',[PetugasData::class,'data']);
            Route::get('detail/{id}',[PetugasData::class,'detail'])->name('.detail');
            Route::get('get_detail',[PetugasData::class,'get_detail'])->name('.get_detail');
            Route::get('data/get_detail',[PetugasData::class,'data_get_detail'])->name('.data.get_detail');
            Route::post('post_detail',[PetugasData::class,'post_detail'])->name('.post_detail');
            Route::post('update_detail',[PetugasData::class,'update_detail'])->name('.update_detail');
            Route::delete('delete_detail',[PetugasData::class,'delete_detail'])->name('.delete_detail');

            Route::get('wilayah_by_id',[PetugasData::class,'wilayah_by_id'])->name('.wilayah_by_id');
            Route::post('wilayah_by_id',[PetugasData::class,'post_wilayah_by_id'])->name('.post_wilayah_by_id');
            Route::delete('wilayah_by_id',[PetugasData::class,'delete_wilayah_by_id'])->name('.delete_wilayah_by_id');
            Route::get('bencana_id',[PetugasData::class,'bencana_id'])->name('.bencana_id');

            Route::get('tahun_by_id',[PetugasData::class,'tahun_by_id'])->name('.tahun_by_id');

            Route::get('show_data',[PetugasData::class,'show_data'])->name('.show_data');

            //show_data_wilayah_by_bencana
            Route::get('wilayah_by_bencana',[PetugasData::class,'wilayah_by_bencana'])->name('.wilayah_by_bencana');
            //show_data_tahun_by_wilayah_by_bencana
            Route::get('tahun_by_wilayah_by_bencana',[PetugasData::class,'tahun_by_wilayah_by_bencana'])->name('.tahun_by_wilayah_by_bencana');
            //show_data_tahun_by_wilayah_by_bencana
            Route::get('data_tahun_by_wilayah_by_bencana',[PetugasData::class,'data_tahun_by_wilayah_by_bencana'])->name('.data_tahun_by_wilayah_by_bencana');

            Route::get('show_wilayah_by_bencana',[PetugasData::class,'show_wilayah_by_bencana'])->name('.show_wilayah_by_bencana');
            Route::get('show_tahun_by_wilayah_by_bencana',[PetugasData::class,'show_tahun_by_wilayah_by_bencana'])->name('.show_tahun_by_wilayah_by_bencana');
            Route::get('show_data_tahun_by_wilayah_by_bencana',[PetugasData::class,'show_data_tahun_by_wilayah_by_bencana'])->name('.show_data_tahun_by_wilayah_by_bencana');
        });

        Route::patch('update_bencana',[PetugasBencana::class,'update_bencana'])->name('.update_bencana');

        Route::get('wilayah',[PetugasWilayah::class,'wilayah'])->name('.wilayah');
        Route::patch('update_wilayah',[PetugasWilayah::class,'update_wilayah'])->name('.update_wilayah');
        Route::get('wilayah/{id}/delete',[PetugasWilayah::class,'delete_wilayah']);

    });
});