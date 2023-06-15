<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\Wilayah;
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
            // dd($data);
            return view('Petugas.data.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function show_data($value='')
    {
        $bencana = isset(request()->bencana)?request()->bencana:'';
        $wilayah = isset(request()->wilayah)?request()->wilayah:'';
        $tahun = isset(request()->tahun)?request()->tahun:'';
        // dd($bencana,$wilayah,$tahun);
        $dbpw = DataBencanaPerWilayah::
        leftJoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftJoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        leftJoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        where('bencana_per_wilayah.id_bencana','like','%'.$bencana.'%')->
        where('bencana_per_wilayah.id_wilayah','like','%'.$wilayah.'%')->
        where(DB::raw('YEAR(data_bencana_per_wilayah.tgl_terjadi)'),'like','%'.$tahun.'%')->
        get();
        $data_bencana_per_wilayah=array();
        $arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        foreach ($dbpw as $key => $value) {
            array_push($data_bencana_per_wilayah,[
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
            ]);
        }
        $data = [
            'data'=>$data_bencana_per_wilayah,
        ];
        return response()->json($data);
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
    public function post_detail(Request $request)
    {
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
        $status = 'sukses';
        // if ($request->jumlah>0&&$request->jumlah_update>0) {
        //     // $status = 'masuk';
        $update_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl)->update([
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->desc,
        ]);
        if ($update_data) {
            $status = 'sukses';
        }
        else{
            $status = 'gagal';
        }
        // }
        // else{
        //     $status = 'gagal update';
        // }
        $data = [
            // 'tgl'=>$request->tgl,
            // 'jumlah'=>$request->jumlah,
            // 'tgl_update'=>$request->tgl_update,
            // 'jumlah_update'=>$request->jumlah_update,
            // 'id'=>$request->id,
            'status'=>$status,
        ];
        return response()->json($request);
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
    public function wilayah_by_id()
    {
        $wilayah = BencanaPerWilayah::leftJoin('wilayah','id_wilayah','id')->where('id_bencana',request()->id)->get();
        $data = [
            'wilayah'=>$wilayah,
        ];
        return response()->json($data);
    }
    public function tahun_by_id()
    {
        $tahun = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        where('id_bencana','=',request()->id)->
        where('id_wilayah','=',request()->id)->
        get();
        $data = [
            'tahun'=>$tahun,
        ];
        return response()->json($data);
    }
    public function bencana_id()
    {
        $wilayah = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('wilayah','id_wilayah','wilayah.id')->
        leftjoin('bencana','id_bencana','bencana.id')->
        where('id_bencana',request()->id)->
        get();
        $data = [
            'wilayah'=>$wilayah,
        ];
        return response()->json($data);
    }
    public function post_wilayah_by_id(Request $request)
    {
        $status="";
        // return response()->json('aa');
        if ($request->wilayah!=""&&$request->tanggal!=""&&$request->jumlah!=""&&$request->deskripsi!="") {
            // return response()->json($request->wilayah!=""&&$request->tanggal!=""&&$request->jumlah!=""&&$request->deskripsi!="");
            $cek_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->wilayah)->where('tgl_terjadi','=',$request->tanggal)->exists();
            
            // return response()->json($cek_data);
            if ($cek_data) {
                $data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->wilayah)->where('tgl_terjadi','=',$request->tanggal)->first();
                $update_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->wilayah)->where('tgl_terjadi','=',$request->tanggal)->update([
                    'jumlah' => $data->jumlah+$request->jumlah,
                ]);
                // return response()->json($update_data);
                if ($update_data) {
                    $status = 'sukses';
                }
                else{
                    $status = 'gagal';
                }
            }
            else{
                $input_data = DataBencanaPerWilayah::create([
                    'id_bencana_per_wilayah' => $request->wilayah,
                    'jumlah' => $request->jumlah,
                    'deskripsi' => $request->deskripsi,
                    'tgl_terjadi' => $request->tanggal,
                ]);
                // return response()->json($input_data,);
                if ($input_data) {
                    $status = 'sukses';
                }
                else{
                    $status = 'gagal';
                }
            }
        }
        $data = [
            'status' => $status,
        ];
        return response()->json($data);
    }
    public function delete_wilayah_by_id(Request $request)
    {
        $status = "";
        $hapus_data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->where('tgl_terjadi','=',$request->tgl)->delete();
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
    public function wilayah_by_bencana()
    {
        $data_bencana = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        get();
        $data = [
            'data'=>$data_bencana,
        ];
        return response()->json($data);
    }
    public function tahun_by_wilayah_by_bencana()
    {
        $data_bencana = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        where('bencana_per_wilayah.id_wilayah','=',request()->id_wilayah)->
        get();
        $data = [
            'data'=>$data_bencana,
        ];
        return response()->json($data);
    }
    public function data_tahun_by_wilayah_by_bencana()
    {
        $data_tahun = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        where('bencana_per_wilayah.id_wilayah','=',request()->id_wilayah)->
        where(DB::raw('YEAR()'),'=',request()->tahun)->
        get();
        $data = [
            'data'=>$data_tahun,
        ];
        return response()->json($data);
    }
    public function show_wilayah_by_bencana()
    {
        $dbpw = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        get();
        $data_bencana_per_wilayah=array();
        $arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        foreach ($dbpw as $key => $value) {
            array_push($data_bencana_per_wilayah,[
                'id'=>$value->id_bencana_per_wilayah,
                'tgl_terjadi'=>$value->tgl_terjadi,
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
            ]);
        }
        $data = [
            'data'=>$data_bencana_per_wilayah,
        ];
        return response()->json($data);
    }
    public function show_tahun_by_wilayah_by_bencana()
    {
        $dbpw = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        where('bencana_per_wilayah.id_wilayah','=',request()->id_wilayah)->
        get();
        $data_bencana_per_wilayah=array();
        $arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        foreach ($dbpw as $key => $value) {
            array_push($data_bencana_per_wilayah,[
                'id'=>$value->id_bencana_per_wilayah,
                'tgl_terjadi'=>$value->tgl_terjadi,
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
            ]);
        }
        $data = [
            'data'=>$data_bencana_per_wilayah,
        ];
        return response()->json($data);
    }
    public function show_data_tahun_by_wilayah_by_bencana()
    {
        $all_wilayah=0;
        foreach (Wilayah::all() as $key => $value) {
            $bencana_per_wilayah = BencanaPerWilayah::where('id_bencana','=',request()->id_bencana)->where('id_wilayah','=',$value['id'])->get();
            foreach($bencana_per_wilayah as $key_bpw => $value_bpw){
                $data_bencana_per_wilayah = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$value_bpw['id_bencana_per_wilayah'])->get();
                foreach ($data_bencana_per_wilayah as $key_dbpw => $value_dbpw) {
                    $all_wilayah += $value_dbpw['jumlah'];
                }
            }
        }

        $dbpw = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        where('bencana_per_wilayah.id_bencana','=',request()->id_bencana)->
        where('bencana_per_wilayah.id_wilayah','=',request()->id_wilayah)->
        where(DB::raw('YEAR(tgl_terjadi)'),'=',request()->tahun)->
        get();
        $data_bencana_per_wilayah=array();
        $arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        foreach ($dbpw as $key => $value) {
            array_push($data_bencana_per_wilayah,[
                'id'=>$value->id_bencana_per_wilayah,
                'tgl_terjadi'=>$value->tgl_terjadi,
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
                'pembagi'=>$all_wilayah,
            ]);
        }
        $data = [
            'data'=>$data_bencana_per_wilayah,
        ];
        return response()->json($data);
    }
}
