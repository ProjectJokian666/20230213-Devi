<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bencana;

use Illuminate\Support\Facades\Http;

class InformasiController extends Controller
{
    public function informasi()
    {
        // $data_auto_gempa = simplexml_load_file("https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml") or die("Gagal mengakses!");
        // $data_gempa_terkini = simplexml_load_file("https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.xml") or die("Gagal mengakses!");
        // $data_auto_gempa = simplexml_load_file("https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml") or die("Gagal mengakses!");
        $status = "";
        if(@fsockopen('data.bmkg.go.id',443)){
            $data_gempa_dirasakan = simplexml_load_file("https://data.bmkg.go.id/DataMKG/TEWS/gempadirasakan.xml");
            $status='sukses';
        }
        else{
            $data_auto_gempa = "";
            $status='gagal';
        }

        $data = [
            'bencana' => Bencana::all(),
            // 'auto_gempa' => $data_auto_gempa,
            'status' => $status,
            // 'gempa_terkini' => $data_gempa_terkini,
            'gempa_dirasakan' => $data_gempa_dirasakan,
        ];   
        // dd($data);
        return view('guest.informasi.index',compact('data'));
    }
    public function get_auto_gempa()
    {
        $status = "";
        if(@fsockopen('data.bmkg.go.id',443)){
            $data_auto_gempa = simplexml_load_file("https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json") or die("Gagal mengakses!");
            $status='sukses';
        }
        else{
            $data_auto_gempa = "";
            $status='gagal';
        }
        $data=[
            'status'=>$status,
            'data_auto_gempa'=>$data_auto_gempa,
        ];
        return response()->json($data);
    }
}
