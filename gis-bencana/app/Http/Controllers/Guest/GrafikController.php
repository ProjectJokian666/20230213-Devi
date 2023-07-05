<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;
use App\Models\Wilayah;

use DB;

class GrafikController extends Controller
{
    public function grafik()
    {   
        // dd($data,$data['Bencana'],json_encode($data['Bencana']),$data['Rinci'],json_encode($data['Rinci']));
        // return view('guest.grafik.index',compact('data'));
        $data = [
            'filter_tahun' => DataBencanaPerWilayah::select(DB::raw('YEAR(tgl_terjadi) as tahun'))->groupBy(DB::raw('YEAR(tgl_terjadi)'))->orderBy('tahun','DESC')->get(),
        ];
        // dd($data);
        return view('guest.grafik.index',compact('data'));
        // return view('guest.grafik.index2',compact('data'));
    }
    public function get_bencana()
    {
        $data_bencana=[];
        $rincian_data_bencana=[];
        if (request()->tahun) {
            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                foreach (BencanaPerWilayah::where('id_bencana',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->where(DB::RAW('YEAR(tgl_terjadi)'),request()->tahun)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_bencana ++;
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($value->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($value->nama_bencana),
                ]);
            }
        }
        else{
            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                foreach (BencanaPerWilayah::where('id_bencana',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_bencana ++;
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($value->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($value->nama_bencana),
                ]);
            }
        }
        $data = [
            'Bencana' => $data_bencana,
            'Rinci' => $rincian_data_bencana,
        ];
        return response()->json($data,200);
    }
    public function get_terjadi()
    {
        $data_wilayah=[];
        $rincian_data_bencana=[];
        if (request()->tahun) {
            foreach(Wilayah::all() as $key => $value){
                $jumlah_wilayah = 0;
                foreach (BencanaPerWilayah::where('id_wilayah',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->where(DB::RAW('YEAR(tgl_terjadi)'),request()->tahun)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_wilayah = $jumlah_wilayah+$value_dbpw->jumlah;
                    }
                }
                array_push($data_wilayah,[
                    'name'=>strtoupper($value->nama_wilayah),
                    'y'=>$jumlah_wilayah,
                    "drilldown"=>strtoupper($value->nama_wilayah),
                ]);
            }
        }
        else{
            foreach(Wilayah::all() as $key => $value){
                $jumlah_wilayah = 0;
                foreach (BencanaPerWilayah::where('id_wilayah',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_wilayah = $jumlah_wilayah+$value_dbpw->jumlah;
                    }
                }
                array_push($data_wilayah,[
                    'name'=>strtoupper($value->nama_wilayah),
                    'y'=>$jumlah_wilayah,
                    "drilldown"=>strtoupper($value->nama_wilayah),
                ]);
            }
        }
        $data = [
            'Wilayah' => $data_wilayah,
            'Rinci' => $rincian_data_bencana,
        ];
        return response()->json($data,200);
    }
    public function get_grafik()
    {
        $data_bencana=[];
        $rincian_data_bencana=[];

        if (request()->tahun) {
            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                foreach (BencanaPerWilayah::where('id_bencana',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->where(DB::RAW('YEAR(tgl_terjadi)'),request()->tahun)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_bencana = $jumlah_bencana+$value_dbpw->jumlah;
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($value->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($value->nama_bencana),
                ]);
            }

            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                $rincian_data_wilayah= [];
                foreach (Wilayah::all() as $key_wilayah => $value_wilayah) {
                    $count_jumlah=0;
                    foreach (BencanaPerWilayah::where('id_bencana',$value->id)->where('id_wilayah',$value_wilayah->id)->get() as $key_bpw => $value_bpw) {
                        foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->where(DB::RAW('YEAR(tgl_terjadi)'),request()->tahun)->get() as $key_dbpw => $value_dbpw) {
                            $count_jumlah = $count_jumlah+$value_dbpw->jumlah;
                        }
                    }
                    array_push($rincian_data_wilayah,[
                        strtoupper($value_wilayah->nama_wilayah),
                        $count_jumlah,
                    ]);
                }
                array_push($rincian_data_bencana,[
                    "name"=>strtoupper($value->nama_bencana),
                    "id"=>strtoupper($value->nama_bencana),
                    "data"=>$rincian_data_wilayah,
                ]);
            }


        }
        else{
            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                foreach (BencanaPerWilayah::where('id_bencana',$value->id)->get() as $key_bpw => $value_bpw) {
                    foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->get() as $key_dbpw => $value_dbpw) {
                        $jumlah_bencana = $jumlah_bencana+$value_dbpw->jumlah;
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($value->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($value->nama_bencana),
                ]);
            }

            foreach(Bencana::all() as $key => $value){
                $jumlah_bencana = 0;
                $rincian_data_wilayah= [];
                foreach (Wilayah::all() as $key_wilayah => $value_wilayah) {
                    $count_jumlah=0;
                    foreach (BencanaPerWilayah::where('id_bencana',$value->id)->where('id_wilayah',$value_wilayah->id)->get() as $key_bpw => $value_bpw) {
                        foreach (DataBencanaPerWilayah::where('id_bencana_per_wilayah',$value_bpw->id_bencana_per_wilayah)->get() as $key_dbpw => $value_dbpw) {
                            $count_jumlah = $count_jumlah+$value_dbpw->jumlah;
                        }
                    }
                    array_push($rincian_data_wilayah,[
                        strtoupper($value_wilayah->nama_wilayah),
                        $count_jumlah,
                    ]);
                }
                array_push($rincian_data_bencana,[
                    "name"=>strtoupper($value->nama_bencana),
                    "id"=>strtoupper($value->nama_bencana),
                    "data"=>$rincian_data_wilayah,
                ]);
            }
        }

        $data = [
            'Bencana' => $data_bencana,
            'Rinci' => $rincian_data_bencana,
        ];
        return response()->json($data,200);
    }

    public function get_grafik2()
    {   
        // dd("a");
        if(request()->tanggal1&&request()->tanggal2){
            //data bencana
            $get_data_bencana = Bencana::all();
            $data_bencana = [];
            foreach($get_data_bencana as $gdb){
                $jumlah_bencana = 0;
                foreach($gdb->bencanaperwilayah as $bpw){
                    // dd($bpw->data_per_wilayah->whereBetween('tgl_terjadi',[request()->tanggal1,request()->tanggal2]));
                    foreach ($bpw->data_per_wilayah->whereBetween('tgl_terjadi',[request()->tanggal1,request()->tanggal2]) as $dpw) {
                        $jumlah_bencana+=$dpw->jumlah;
                        // if ($dpw->tgl_terjadi==request()->tanggal) {
                        // }
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($gdb->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($gdb->nama_bencana),
                ]);
            // $data_bencana[]=$gdb;
            }

            // rincian data bencana
            $get_rincian_data_bencana = Bencana::all();
            $rincian_data_bencana = [];

            $get_data_wilayah = Wilayah::all();
            foreach($get_rincian_data_bencana as $grdb){
                $rincian_data_wilayah= [];
                foreach($get_data_wilayah as $gdw){
                    $count_jumlah=0;
                    // cek ketersediaan data
                    $data_bencana_per_wilayah = BencanaPerWilayah::where('id_bencana','=',$grdb->id)->where('id_wilayah','=',$gdw->id)->first();

                    if ($data_bencana_per_wilayah!=null) {
                        $jumlah_data_bencana = DataBencanaPerWilayah::
                        where('id_bencana_per_wilayah','=',$data_bencana_per_wilayah->id_bencana_per_wilayah)->
                        whereBetween('tgl_terjadi',[request()->tanggal1,request()->tanggal2])->
                        get();
                        // cek ketersediaan data
                        if ($jumlah_data_bencana!=null) {
                            foreach ($jumlah_data_bencana as $jdb) {
                                $count_jumlah+=$jdb->jumlah;
                            }
                        }
                    }
                    array_push($rincian_data_wilayah,[
                        strtoupper($gdw->nama_wilayah),
                        $count_jumlah,
                    ]);
                // $rincian_data_wilayah=array{$gdw->nama_wilayah,$count_jumlah};
                }
                array_push($rincian_data_bencana,[
                    "name"=>strtoupper($grdb->nama_bencana),
                    "id"=>strtoupper($grdb->nama_bencana),
                    "data"=>$rincian_data_wilayah,
                ]);
            }

            $data = [
                'Bencana' => $data_bencana,
                'Rinci' => $rincian_data_bencana,
            ];

            // dd(request()->tanggal1,request()->tanggal2,$data);
            return response()->json($data,200);
        }
        else{
            //data bencana
            $get_data_bencana = Bencana::all();
            $data_bencana = [];
            foreach($get_data_bencana as $gdb){
                $jumlah_bencana = 0;
                foreach($gdb->bencanaperwilayah as $bpw){
                    foreach ($bpw->data_per_wilayah as $dpw) {
                        $jumlah_bencana+=$dpw->jumlah;
                    }
                }
                array_push($data_bencana,[
                    'name'=>strtoupper($gdb->nama_bencana),
                    'y'=>$jumlah_bencana,
                    "drilldown"=>strtoupper($gdb->nama_bencana),
                ]);
            // $data_bencana[]=$gdb;
            }


            //rincian data bencana
            $get_rincian_data_bencana = Bencana::all();
            $rincian_data_bencana = [];

            $get_data_wilayah = Wilayah::all();
            foreach($get_rincian_data_bencana as $grdb){
                $rincian_data_wilayah= [];
                foreach($get_data_wilayah as $gdw){
                    $count_jumlah=0;
                //cek ketersediaan data
                    $data_bencana_per_wilayah = BencanaPerWilayah::where('id_bencana','=',$grdb->id)->where('id_wilayah','=',$gdw->id)->first();

                    if ($data_bencana_per_wilayah!=null) {
                        $jumlah_data_bencana = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$data_bencana_per_wilayah->id_bencana_per_wilayah)->get();
                    //cek ketersediaan data
                        if ($jumlah_data_bencana!=null) {
                            foreach ($jumlah_data_bencana as $jdb) {
                                $count_jumlah+=$jdb->jumlah;
                            }
                        }
                    }
                    array_push($rincian_data_wilayah,[
                        strtoupper($gdw->nama_wilayah),
                        $count_jumlah,
                    ]);
                // $rincian_data_wilayah=array{$gdw->nama_wilayah,$count_jumlah};
                }
                array_push($rincian_data_bencana,[
                    "name"=>strtoupper($grdb->nama_bencana),
                    "id"=>strtoupper($grdb->nama_bencana),
                    "data"=>$rincian_data_wilayah,
                ]);
            }

            $data = [
                'Bencana' => $data_bencana,
                'Rinci' => $rincian_data_bencana,
            ];

            return response()->json($data,200);
        }

        $data = [
            'Bencana' => $data_bencana,
            'Rinci' => $rincian_data_bencana,
        ];
    }
}
