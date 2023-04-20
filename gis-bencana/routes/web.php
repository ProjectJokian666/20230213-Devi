<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenController as Authen;

use App\Http\Controllers\DashboardController as Dashboard;

use App\Http\Controllers\AdminController as Admin;
use App\Http\Controllers\Admin\PetugasController as AdminPetugas;
use App\Http\Controllers\Admin\WilayahController as AdminWilayah;
use App\Http\Controllers\Admin\BencanaController as AdminBencana;
use App\Http\Controllers\Admin\BencanaPerWilayahController as AdminBencanaPerWilayah;

use App\Http\Controllers\PetugasController as Petugas;
use App\Http\Controllers\Petugas\WilayahController as PetugasWilayah;
use App\Http\Controllers\Petugas\BencanaController as PetugasBencana;

use App\Http\Controllers\Guest\PetaController as Peta;
use App\Http\Controllers\Guest\GrafikController as Grafik;
use App\Http\Controllers\Guest\InformasiController as Informasi;

Route::get('/',[Dashboard::class,'index'])->name('index');
Route::prefix('peta')->name('peta.')->group(function(){
    Route::get('',[Peta::class,'peta'])->name('peta');
});
Route::prefix('grafik')->name('grafik.')->group(function(){
    Route::get('',[Grafik::class,'grafik'])->name('grafik');
});
Route::prefix('informasi')->name('informasi.')->group(function(){
    Route::get('',[Informasi::class,'informasi'])->name('informasi');
});

Route::middleware('guest')->group(function(){
    Route::get('login',[Authen::class,'login'])->name('login');
    Route::post('login',[Authen::class,'plogin'])->name('plogin');
});

Route::middleware('auth')->group(function(){
    Route::get('logout',[Authen::class,'logout'])->name('logout');

    Route::get('profil',[Authen::class,'profil'])->name('profil');
    Route::post('profil',[Authen::class,'pprofil'])->name('pprofil');

    Route::prefix('admin')->name('admin')->group(function(){
        Route::get('',[Admin::class,'admin']);

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

        Route::post('add_bencana',[AdminBencana::class,'add_bencana'])->name('.add_bencana');
        Route::patch('update_bencana',[AdminBencana::class,'update_bencana'])->name('.update_bencana');
        Route::delete('delete_bencana',[AdminBencana::class,'delete_bencana'])->name('.delete_bencana');

        Route::get('wilayah',[AdminWilayah::class,'wilayah'])->name('.wilayah');
        Route::post('add_wilayah',[AdminWilayah::class,'add_wilayah'])->name('.add_wilayah');
        Route::patch('update_wilayah',[AdminWilayah::class,'update_wilayah'])->name('.update_wilayah');
        Route::delete('delete_wilayah',[AdminWilayah::class,'delete_wilayah'])->name('.delete_wilayah');
    });
    
    Route::prefix('petugas')->name('petugas')->group(function(){
        Route::get('',[Petugas::class,'petugas']);

        Route::prefix('bencana')->name('.bencana')->group(function(){
            Route::get('',[PetugasBencana::class,'bencana']);

            Route::get('wilayah/{id}',[PetugasBencana::class,'wilayah'])->name('.wilayah');
            Route::post('wilayah/{id}',[PetugasBencana::class,'show_wilayah'])->name('.show_wilayah');
            Route::patch('wilayah/{id}',[PetugasBencana::class,'update_wilayah'])->name('.update_wilayah');
            Route::patch('wilayah/{id}/ubah',[PetugasBencana::class,'ubah_wilayah'])->name('.ubah_wilayah');
            Route::delete('wilayah/{id}',[PetugasBencana::class,'delete_wilayah'])->name('.delete_wilayah');
        });

        Route::patch('update_bencana',[PetugasBencana::class,'update_bencana'])->name('.update_bencana');

        Route::get('wilayah',[PetugasWilayah::class,'wilayah'])->name('.wilayah');
        Route::patch('update_wilayah',[PetugasWilayah::class,'update_wilayah'])->name('.update_wilayah');
    });
});