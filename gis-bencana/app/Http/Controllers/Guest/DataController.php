<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DataController extends Controller
{
    public function data()
    {   
        $data = [
            'bencana' => Bencana::all(),
        ];
        // dd($data);
        return view('Guest.data.index',compact('data'));
    }

    public function detail($id)
    {
            // dd($id);
        $list_kejadian=[];
        $data_bencana_per_wilayah = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$id)->orderBy('tgl_terjadi','desc')->get();
        foreach ($data_bencana_per_wilayah as $key => $value) {
            array_push($list_kejadian,[
                'jumlah'=>$value['jumlah'],
                'tgl_terjadi'=>$value['tgl_terjadi'],
            ]);
        }

        $bw = BencanaPerWilayah::where('id_bencana_per_wilayah','=',$id)->first();
        $data = [
            'bencana' => $bw->bencana->nama_bencana,
            'wilayah' => $bw->wilayah->nama_wilayah,
            'data' => $list_kejadian,
        ];
            // dd($data);
        return view('Guest.data.detail',compact('data'));
    }

}
