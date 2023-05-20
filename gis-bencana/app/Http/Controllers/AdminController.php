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

        $bencana = Bencana::find(request()->bencana);

        $file_wilayah = "";

        $i = 0;
        $b = Wilayah::count();
        foreach (Wilayah::all() as $key_wilayah => $value_wilayah) {
            $i++;
            // echo Wilayah::count();
            $file_wilayah .= "{";
            $file_wilayah .= '"id":"'.$value_wilayah['id'].'",';
            $file_wilayah .= '"nama":"'.$value_wilayah['nama_wilayah'].'",';
            $file_wilayah .= file_get_contents('Data_Wilayah/'.$value_wilayah['file_wilayah']);
            if ($i<$b) {
                $file_wilayah .= "},";
            }
            else{
                $file_wilayah .= "}";
            }
            // $file_wilayah = file_get_contents('Data_Wilayah/'.$value_bencana['file_wilayah']);
            // $file_wilayah = str_replace([' ','\r\n'],['','',''],$file_wilayah);
            // $file_wilayah = json_encode("{".$file_wilayah."}");
            // dd($file_wilayah);
            // array_push($array_bencana,[
            //     'id'=>$value_bencana['id'],
            //     'nama'=>$value_bencana['nama_wilayah'],
            //     'wilayah'=>$file_wilayah,
            // ]);
        }
        // $file_wilayah = str_replace([' ','\r\n'],['','',''],$file_wilayah);
        // $file_wilayah = json_encode($file_wilayah);

        $data = [
            // 'bencana'=>$array_bencana,
            'wilayah'=>$file_wilayah,
        ];
        // dd($data);
        return response()->json($data);
    }
    public function get_maps2()
    {
        // dd(request());
        $array_bencana = [];

        $bencana = Bencana::find(request()->bencana);

        $file_wilayah = "";

        foreach (Wilayah::all() as $key_bencana => $value_bencana) {
            $file_wilayah = file_get_contents('Data_Wilayah/'.$value_bencana['file_wilayah']);
            // $file_wilayah = str_replace([' ','\r\n'],['','',''],$file_wilayah);
            // $file_wilayah = json_encode("{".$file_wilayah."}");
            // dd($file_wilayah);
            // array_push($array_bencana,[
            //     'id'=>$value_bencana['id'],
            //     'nama'=>$value_bencana['nama_wilayah'],
            //     'wilayah'=>$file_wilayah,
            // ]);
        }
        $data = [
            // 'bencana'=>$array_bencana,
            'wilayah'=>$file_wilayah,
        ];
        // dd($data);
        return response()->json($data);
    }
}
