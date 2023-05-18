<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

class DataController extends Controller
{
    public function data()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }

            $data = [
                'bencana' => Bencana::all(),
            ];

            return view('Admin.data.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function detail($id)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
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
            return view('Admin.data.detail',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

}
