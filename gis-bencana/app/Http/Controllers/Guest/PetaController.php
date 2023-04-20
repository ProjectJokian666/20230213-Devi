<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wilayah;
use App\Models\DataBencanaPerWilayah;

class PetaController extends Controller
{
    public function peta(Request $request)
    {   
        $data = [
            'wilayah'=>Wilayah::all(),
            // 'data_bencana'=>DataBencanaPerWilayah::all(),
        ];
        // dd($data,$request->cari_tahun);
        return view('guest.peta.index',compact('data'));
    }
}
