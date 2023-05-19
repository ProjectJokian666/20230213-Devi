<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Wilayah;
use App\Models\Bencana;

class AdminController extends Controller
{
    public function admin()
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('/');
        }
        $data = [
            'bencana'=>Bencana::all(),
            'wilayah'=>Wilayah::all(),
        ];
        return view('Admin.index',compact('data'));
    }

    public function get_maps()
    {
        // dd(request());
        $array_bencana = [];

        foreach (Wilayah::all() as $key_bencana => $value_bencana) {
            $file_wilayah = file_get_contents('Data_Wilayah/'.$value_bencana['file_wilayah']);
            $file_wilayah = str_replace([' ','\r\n'],['',''],$file_wilayah);
            dd($file_wilayah);
            array_push($array_bencana,[
                'id'=>$value_bencana['id'],
                'nama'=>$value_bencana['nama_wilayah'],
                'wilayah'=>$file_wilayah,
            ]);
        }
        $data = [
            'bencana'=>$array_bencana,
        ];
        dd($data);
        return response()->json($data);
    }
}
