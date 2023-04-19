<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Bencana;
use App\Models\Wilayah;
use App\Models\BencanaPerWilayah;
use App\Models\DataBencanaPerWilayah;

class BencanaController extends Controller
{
    public function bencana()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = [
                'bencana' => Bencana::all(),
            ];
            return view('Admin.bencana.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function add_bencana(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = Bencana::create([
                'nama_bencana' => $request->bencana,
                'deskripsi_bencana' => $request->deskripsi,
            ]);
            if ($data) {
                return redirect('admin/bencana')->with('sukses','Data berhasil ditambahkan');
            }
            else{
                return redirect('admin/bencana')->with('gagal','Data gagal ditambahkan');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function update_bencana(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = Bencana::where('id','=',$request->id)->update([
                'nama_bencana' => $request->bencana,
                'deskripsi_bencana' => $request->deskripsi,
            ]);
            if ($data) {
                return redirect('admin/bencana')->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('admin/bencana')->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function delete_bencana(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = Bencana::where('id','=',$request->id)->delete();
            DB::statement('alter table bencana auto_increment=0');
            if ($data) {
                return redirect('admin/bencana')->with('sukses','Data berhasil dihapus');
            }
            else{
                return redirect('admin/bencana')->with('gagal','Data gagal dihapus');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function wilayah($id)
    {   
        $array_data_wilayah = array();
        $data_wilayah = Wilayah::all();
        foreach($data_wilayah as $dw){
            array_push($array_data_wilayah,$dw->id);
        }

        $array_data_wilayah_exist=array();
        $data_wilayah_exist = BencanaPerWilayah::where('id_bencana','=',$id)->get();
        foreach($data_wilayah_exist as $dwe){
            array_push($array_data_wilayah_exist,$dwe->id_wilayah);
        }

        $array_data_wilayah_show=array();
        if(array_diff($array_data_wilayah,$array_data_wilayah_exist)!=null){
            foreach(array_diff($array_data_wilayah,$array_data_wilayah_exist) as $ad){
                $data_wilayah_input = Wilayah::find($ad);
                array_push($array_data_wilayah_show,[
                    'id' => $data_wilayah_input->id,
                    'nama_wilayah' => $data_wilayah_input->nama_wilayah,
                ]);
            }
        }

        $data = [
            'bencana' => Bencana::find($id),
            'wilayah' => BencanaPerWilayah::where('id_bencana','=',$id)->get(),
            'data_wilayah_show' => $array_data_wilayah_show,
        ];

        // dd($array_data_wilayah,$array_data_wilayah_exist,$array_data_wilayah_show,$data);
        return view('admin.bencana.wilayah.index',compact('data'));
    }

    public function add_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $input_data = BencanaPerWilayah::create([
                'id_bencana' => $id,
                'id_wilayah' => $request->wilayah,
            ]);
            if ($input_data) {
                return redirect('admin/bencana/wilayah/'.$id)->with('sukses','Data berhasil ditambahkan');
            }
            else{
                return redirect('admin/bencana/wilayah/'.$id)->with('gagal','Data gagal ditambahkan');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function patch_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            
            $ubah_bencana_per_wilayah = BencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->update([
                'id_wilayah' => $request->wilayah,
            ]);
            
            if ($ubah_bencana_per_wilayah) {
                return redirect('admin/bencana/wilayah/'.$id)->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('admin/bencana/wilayah/'.$id)->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function delete_wilayah(Request $request,$id){
        // dd($request,$id);
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $hapus_bencana_per_wilayah = BencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->delete();
            DB::statement('alter table bencana_per_wilayah auto_increment=0');
            $hapus_data_bencana_per_wilayah = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$request->id)->delete();
            if ($hapus_bencana_per_wilayah) {
                return redirect('admin/bencana/wilayah/'.$id)->with('sukses','Data berhasil dihapus');
            }
            else{
                return redirect('admin/bencana/wilayah/'.$id)->with('gagal','Data gagal dihapus');
            }
        }
        else{
            return redirect('login');
        }
    }
}
