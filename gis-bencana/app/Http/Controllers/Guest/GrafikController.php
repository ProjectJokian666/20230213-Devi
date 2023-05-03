<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;
use App\Models\Wilayah;

class GrafikController extends Controller
{
    public function grafik()
    {   
        // dd($data,$data['Bencana'],json_encode($data['Bencana']),$data['Rinci'],json_encode($data['Rinci']));
        // return view('guest.grafik.index',compact('data'));
        return view('guest.grafik.index');
        // return view('guest.grafik.index2',compact('data'));
    }

    public function get_grafik()
    {
        if(request()->tanggal){
            //data bencana
            $get_data_bencana = Bencana::all();
            $data_bencana = [];
            foreach($get_data_bencana as $gdb){
                $jumlah_bencana = 0;
                foreach($gdb->bencanaperwilayah as $bpw){
                    foreach ($bpw->data_per_wilayah as $dpw) {
                        if ($dpw->tgl_terjadi==request()->tanggal) {
                            $jumlah_bencana+=$dpw->jumlah;
                        }
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
                        $jumlah_data_bencana = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$data_bencana_per_wilayah->id_bencana_per_wilayah)->where('tgl_terjadi','=',request()->tanggal)->get();
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

            return response()->json($data,200);
            dd(request()->tanggal);
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
