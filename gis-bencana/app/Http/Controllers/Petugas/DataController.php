<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function data()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }

            $data = [
                'bencana' => Bencana::all(),
            ];

            return view('Petugas.data.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function detail($id)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }
            // dd($id);
            $wilayah = BencanaPerWilayah::where('id_bencana_per_wilayah','=',$id)->first();
            $data = [
                'wilayah' => $wilayah,
            ];
            // dd($data);
            return view('Petugas.data.detail',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function get_detail()
    {
        // dd(request()->wilayah);
        $all_data = [];
        $get_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',request()->wilayah)->get();
        foreach ($get_data as $key => $value) {
            array_push($all_data,[
                'id' => $value['id_bencana_per_wilayah'],
                'jumlah' => $value['jumlah'],
                'tgl_terjadi' => $value['tgl_terjadi'],
                'tgl' => $value['tgl_terjadi'],
            ]);
        }
        $wilayah = $all_data;
        $data = [
            'data' => $wilayah,
        ];
        return response()->json($data);
    }
    public function data_get_detail()
    {
        $data=[
            'data'=>DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',request()->id)->where('jumlah','=',request()->jumlah)->where('tgl_terjadi','=',request()->tgl)->first(),
        ];
        return response()->json($data);
    }
    public function post_detail(Request $request){
        $status = "";
        if ($request->tgl!=null||$request->jumlah!=null&&$request->jumlah>0) {
            $cek_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl)->first();
            if ($cek_data) {
                $update_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl)->update([
                    'jumlah' => $cek_data->jumlah+$request->jumlah,
                ]);
                if ($update_data) {
                    $status = 'sukses';
                }
                else{
                    $status = 'gagal';
                }
            }
            else{
                $input_data = DataBencanaPerWilayah::create([
                    'id_bencana_per_wilayah' => $request->id,
                    'tgl_terjadi' => $request->tgl,
                    'jumlah' => $request->jumlah,
                ]);
                if ($input_data) {
                    $status = 'sukses';
                }
                else{
                    $status = 'gagal';
                }
            }
            // $data = [
            //     'status'=>$status,
            //     'data'=>$cek_data,
            // ];
            // return response()->json($data);
        }
        else{
            $status = 'data kosong';
        }
        $data = [
            'status'=>$status,
            // 'id'=>$request->id,
            // 'jumlah'=>$request->jumlah,
            // 'tgl'=>$request->tgl,
        ];
        return response()->json($data);
    }
    public function update_detail(Request $request)
    {
        $status = '';
        if ($request->jumlah>0&&$request->jumlah_update>0) {
            // $status = 'masuk';
            $update_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl_update)->where('jumlah','=',$request->jumlah_update)->update([
                'jumlah' => $request->jumlah,
            ]);
            if ($update_data) {
                $status = 'sukses';
            }
            else{
                $status = 'gagal';
            }
        }
        else{
            $status = 'gagal update';
        }
        $data = [
            // 'tgl'=>$request->tgl,
            // 'jumlah'=>$request->jumlah,
            // 'tgl_update'=>$request->tgl_update,
            // 'jumlah_update'=>$request->jumlah_update,
            // 'id'=>$request->id,
            'status'=>$status,
        ];
        return response()->json($data);
    }
    public function delete_detail(Request $request)
    {
        $status = "";
        $hapus_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl)->where('jumlah','=',$request->jumlah)->delete();
        if ($hapus_data) {
            $status = 'sukses';
        }
        else{
            $status = 'gagal';
        }
        $data = [
            'status'=>$status,
        ];
        return response()->json($data);
    }
}
