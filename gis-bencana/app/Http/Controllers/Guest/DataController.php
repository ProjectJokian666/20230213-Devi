<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\Wilayah;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function all_bencana($id_bencana,$tahun)
    {
        $hasil=0;
        foreach(Wilayah::all() as $key => $value){
            $data = DataBencanaPerWilayah::
            leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
            where('id_wilayah',$value->id)->
            where('id_bencana',$id_bencana)->
            where(DB::raw('YEAR(tgl_terjadi)'),$tahun)->
            get();
            foreach ($data as $key_data => $value_data) {
                $hasil=$hasil+$value_data->jumlah;
            }
            
        }
        // dd($hasil);
        return $hasil;
    }

    public function all_data()
    {
        $dbpw = DataBencanaPerWilayah::
        leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
        leftjoin('bencana','bencana_per_wilayah.id_bencana','bencana.id')->
        leftjoin('wilayah','bencana_per_wilayah.id_wilayah','wilayah.id')->
        orderBy('nama_bencana','ASC')->
        get();
        $data_bencana_per_wilayah=array();
        $arr_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        foreach ($dbpw as $key => $value) {
            $all_wilayah=0;

            array_push($data_bencana_per_wilayah,[
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
                'id_bencana'=>$value->id_bencana,
                'id_wilayah'=>$value->id_wilayah,
                'pembagi'=>$this->all_bencana($value->id_bencana,DATE('Y',strtotime($value->tgl_terjadi))),
            ]);

        }

        // dd($data_bencana_per_wilayah);
        return $data_bencana_per_wilayah;
    }

    public function data()
    {   
        $all_data = $this->all_data();
        $data = [
            'bencana' => Bencana::all(),
            'data'=>DataBencanaPerWilayah::all(),
            'all_data'=>$all_data,
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
                'tanggal'=>DATE('d',strtotime($value->tgl_terjadi)),
                'bulan'=>$arr_bulan[DATE('m',strtotime($value->tgl_terjadi))-1],
                'tahun'=>DATE('Y',strtotime($value->tgl_terjadi)),
                'nama_bencana'=>$value->nama_bencana,
                'wilayah'=>$value->nama_wilayah,
                'terdampak'=>$value->jumlah,
                'deskripsi'=>$value->deskripsi,
                'pembagi'=>$this->all_bencana($value->id_bencana,DATE('Y',strtotime($value->tgl_terjadi))),
            ]);
        }
        $data = [
            'data'=>$data_bencana_per_wilayah,
        ];
        // dd($data);
        return response()->json($data);
    }
}
