<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wilayah;
use App\Models\Bencana;
use App\Models\BencanaPerWilayah;

use Illuminate\Support\Facades\DB;

class SetWilayahBencanaController extends Controller
{
    public function index(){
        $data = [
            'bencana' => Bencana::all(),
        ];
        return view('admin.setwilayahbencana.index',compact('data'));
    }
    public function show_data()
    {
        $array_data_wilayah = [];
        $data_wilayah = Wilayah::all();
        foreach($data_wilayah as $dw){
            array_push($array_data_wilayah,$dw->id);
        }

        $array_data_wilayah_exist=[];
        $data_wilayah_exist = BencanaPerWilayah::where('id_bencana','=',request()->bencana)->get();
        foreach($data_wilayah_exist as $dwe){
            array_push($array_data_wilayah_exist,$dwe->id_wilayah);
        }
        // dd($array_data_wilayah_exist);

        $array_data_wilayah_show=[];
        if(array_diff($array_data_wilayah,$array_data_wilayah_exist)!=null){
            foreach(array_diff($array_data_wilayah,$array_data_wilayah_exist) as $ad){
                $data_wilayah_input = Wilayah::find($ad);
                array_push($array_data_wilayah_show,[
                    'id' => $data_wilayah_input->id,
                    'nama_wilayah' => $data_wilayah_input->nama_wilayah,
                ]);
            }
        }
        // dd($array_data_wilayah_show);

        // dd(request());
        $data_bencana = BencanaPerWilayah::where('id_bencana','=',request()->bencana)->get();
        $data_wilayah = [];
        foreach ($data_bencana as $key => $value) {
            array_push($data_wilayah,[
                'id_wilayah' => $value['id_wilayah'],
                'nama_wilayah' => $value->wilayah->nama_wilayah,
            ]);
        }
        $data = [
            'wilayah' => $data_wilayah,
            'wilayah_option' => $array_data_wilayah_show,
        ];
        return response()->json($data);
    }
    public function post_data(Request $request)
    {
        // $data = [
        //     'status'=>$request->wilayah,
        // ];
        // return response()->json($data);
        $post_data = BencanaPerWilayah::create([
            'id_bencana' => $request->bencana,
            'id_wilayah' => $request->wilayah,
        ]);
        if ($post_data) {
            $data = [
                'status'=>'sukses'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status'=>'gagal'
            ];
            return response()->json($data);
        }
    }
    public function update_data(Request $request)
    {
        // $data = [
        //     'status'=>$request->wilayah_update
        // ];
        // return response()->json($data);
        $update_data = BencanaPerWilayah::where('id_bencana','=',$request->bencana)->where('id_wilayah','=',$request->wilayah_update)->update([
            'id_wilayah' => $request->wilayah,
        ]);
        if ($update_data) {
            $data = [
                'status'=>'sukses'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status'=>'gagal'
            ];
            return response()->json($data);
        }
    }
    public function delete_data(Request $request)
    {
        $delete_data = BencanaPerWilayah::where('id_bencana','=',$request->bencana)->where('id_wilayah','=',$request->wilayah)->delete();
        DB::statement('alter table bencana_per_wilayah auto_increment=0');
        if ($delete_data) {
            $data = [
                'status'=>'sukses'
            ];
            return response()->json($data);
        }
        else{
            $data = [
                'status'=>'gagal'
            ];
            return response()->json($data);
        }
    }
}
