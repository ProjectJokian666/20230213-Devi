<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wilayah;
use App\Models\Bencana;
use App\Models\DataBencanaPerWilayah;

class PetaController extends Controller
{
    public function peta(Request $request)
    {   
        $data = [
            'wilayah'=>Wilayah::all(),
            'bencana'=>Bencana::all(),
            // 'data_bencana'=>DataBencanaPerWilayah::all(),
        ];
        // dd($data,$request->cari_tahun);
        // dd($data);
        return view('guest.peta.index',compact('data'));
    }
    public function get_peta()
    {
        $area = null;
        // dd(Wilayah::all());
        foreach(Wilayah::all() as $key => $value){
            if (file_exists("Data_Wilayah/".$value->file_wilayah)) {
                // echo $value;
                // $area .= '{'.file_get_contents("Data_Wilayah/".$value->file_wilayah).'},';
                $area .= fopen("Data_Wilayah/".$value->file_wilayah,"w");
            }
        }
        dd($area);
        // array_push($area,trim($a,"\r\n"));

        $data = [
            'Area' => $area,
        ];
        return response()->json($data,200);
    }
}
