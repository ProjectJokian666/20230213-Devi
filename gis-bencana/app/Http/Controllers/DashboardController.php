<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bencana;
use App\Models\Wilayah;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

use DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth()->User()->role=='Admin') {
                return redirect('admin');
            }
            else if (Auth()->User()->role=='Petugas') {
                return redirect('petugas');
            }
        }
        else{
            $data = [
                'bencana'=>Bencana::all(),
            ];
            return view('guest.home',compact('data'));
        }
    }

    public function get_maps()
    {
        // dd(request());
        $array_bencana = [];

        //all bencana di wilayah
        $all_wilayah=0;
        foreach (Wilayah::all() as $key => $value) {
            $bencana_per_wilayah = BencanaPerWilayah::where('id_bencana','=',request()->bencana)->where('id_wilayah','=',$value['id'])->get();
            foreach($bencana_per_wilayah as $key_bpw => $value_bpw){
                $data_bencana_per_wilayah = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$value_bpw['id_bencana_per_wilayah'])->whereBetween('tgl_terjadi',[request()->tanggal1,request()->tanggal2])->get();
                foreach ($data_bencana_per_wilayah as $key_dbpw => $value_dbpw) {
                    $all_wilayah += $value_dbpw['jumlah'];
                }
            }
        }

        // dd($all_wilayah);
        $file_wilayah = "";
        $i = 0;
        $b = Wilayah::count();
        //data bencana
        foreach (Wilayah::all() as $key_wilayah => $value_wilayah) {
            $i++;
            $data_bencana = 0;
            $bencana_per_wilayah = BencanaPerWilayah::where('id_bencana','=',request()->bencana)->where('id_wilayah','=',$value_wilayah['id'])->get();
            // dd($bencana_per_wilayah);
            foreach($bencana_per_wilayah as $key_bpw => $value_bpw){
                $data_bencana_per_wilayah = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$value_bpw['id_bencana_per_wilayah'])->whereBetween('tgl_terjadi',[request()->tanggal1,request()->tanggal2])->get();
                foreach ($data_bencana_per_wilayah as $key_dbpw => $value_dbpw) {
                    $data_bencana += $value_dbpw['jumlah'];
                }
            }
            // echo Wilayah::count();
            $file_wilayah .= "{";
            $file_wilayah .= '"id":"'.$value_wilayah['id'].'",';
            $file_wilayah .= '"properties":{';
            $file_wilayah .= '"nama":"'.$value_wilayah['nama_wilayah'].'",';
            if ($data_bencana!=0) {
                $data_bencana = round($data_bencana/$all_wilayah*100);
            }
            $file_wilayah .= '"data_bencana":'.$data_bencana;
            $file_wilayah .= '},';
            $file_wilayah .= file_get_contents('Data_Wilayah/'.$value_wilayah['file_wilayah']);
            if ($i<$b) {
                $file_wilayah .= "},";
            }
            else{
                $file_wilayah .= "}";
            }
        }

        $data = [
            'wilayah'=>$file_wilayah,
        ];
        return response()->json($data);
    }

    public function get_maps_fix(){

        $file_wilayah="";
        
        if (request()->filter_bencana&&request()->filter_wilayah&&request()->filter_tahun) {
            $i=0;
            $w=Wilayah::where('id','=',request()->filter_wilayah);
            $b=$w->count();

            foreach ($w->get() as $key_wilayah => $value_wilayah) {
                $i++;
                $data_bencana=0;

                $bencana_per_wilayah = BencanaPerWilayah::
                where('id_bencana','=',request()->filter_bencana)->
                where('id_wilayah','=',request()->filter_wilayah)->
                get();

                foreach($bencana_per_wilayah as $key_bpw => $value_bpw){
                    $data_bencana_per_wilayah = DataBencanaPerWilayah::
                    where('id_bencana_per_wilayah','=',$value_bpw->id_bencana_per_wilayah)->
                    where(DB::raw('YEAR(tgl_terjadi)'),'=',request()->filter_tahun)->
                    get();
                    foreach ($data_bencana_per_wilayah as $key_dbpw => $value_dbpw) {
                        $data_bencana =+$value_dbpw->jumlah;
                    }
                }

                $file_wilayah .= "{";
                $file_wilayah .= '"id":"'.$value_wilayah['id'].'",';
                $file_wilayah .= '"properties":{';
                $file_wilayah .= '"nama":"'.$value_wilayah['nama_wilayah'].'",';
                $file_wilayah .= '"terdampak":"'.$data_bencana.'",';
                if ($data_bencana!=0) {
                    $all_wilayah = $this->all_bencana(request()->filter_bencana);
                    $data_bencana = round($data_bencana/$all_wilayah*100,2);
                }
                $file_wilayah .= '"data_bencana":'.$data_bencana;
                $file_wilayah .= '},';
                $file_wilayah .= file_get_contents('Data_Wilayah/'.$value_wilayah['file_wilayah']);
                if ($i<$b) {
                    $file_wilayah .= "},";
                }
                else{
                    $file_wilayah .= "}";
                }
            }
        }
        else{
            $i=0;
            $w=Wilayah::all();
            $b=$w->count();

            foreach ($w as $key_wilayah => $value_wilayah) {
                $i++;
                $file_wilayah .= "{";
                $file_wilayah .= '"id":"'.$value_wilayah['id'].'",';
                $file_wilayah .= '"properties":{';
                $file_wilayah .= '"nama":"'.$value_wilayah['nama_wilayah'].'",';
                $file_wilayah .= '"terdampak":0,';
                $file_wilayah .= '"data_bencana":0';
                $file_wilayah .= '},';
                $file_wilayah .= file_get_contents('Data_Wilayah/'.$value_wilayah['file_wilayah']);
                if ($i<$b) {
                    $file_wilayah .= "},";
                }
                else{
                    $file_wilayah .= "}";
                }
            }
        }

        $data = [
            'wilayah'=>$file_wilayah,
        ];

        return response()->json($data);
    }

    public function all_bencana($id_bencana)
    {
        $hasil=0;
        foreach(Wilayah::all() as $key => $value){
            $data = DataBencanaPerWilayah::
            leftjoin('bencana_per_wilayah','data_bencana_per_wilayah.id_bencana_per_wilayah','bencana_per_wilayah.id_bencana_per_wilayah')->
            where('id_wilayah',$value->id)->
            where('id_bencana',$id_bencana)->
            get();
            foreach ($data as $key_data => $value_data) {
                $hasil=$hasil+$value_data->jumlah;
            }
            
        }
        // dd($hasil,$data,$id_bencana);
        return $hasil;
    }

}
