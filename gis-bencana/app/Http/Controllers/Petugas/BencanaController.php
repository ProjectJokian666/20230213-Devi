<?php

namespace App\Http\Controllers\Petugas;

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
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }
            $data = [
                'bencana' => Bencana::all(),
            ];
            return view('petugas.bencana.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function update_bencana(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }
            $data = Bencana::where('id','=',$request->id)->update([
                'nama_bencana' => $request->bencana,
                'deskripsi_bencana' => $request->deskripsi,
            ]);
            if ($data) {
                return redirect('petugas/bencana')->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('petugas/bencana')->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function wilayah($id)
    {   
        $data = [
            'bencana' => Bencana::find($id),
            'wilayah' => BencanaPerWilayah::where('id_bencana','=',$id)->get(),
        ];

        // dd($data);
        return view('petugas.bencana.wilayah.index',compact('data'));
    }

    public function show_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        $get_data = BencanaPerWilayah::where('id_bencana','=',$id)->where('id_wilayah','=',$request->wilayah)->first();
        $data = [
            'wilayah' => $get_data,
            'bencana' => DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$get_data->id_bencana_per_wilayah)->get(),
        ];
        // dd($data);
        return view('petugas.bencana.wilayah.show',compact('data'));
    }

    public function update_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        $cek_data=DataBencanaPerWilayah::
        where('id_bencana_per_wilayah','=',$request->id_bencana_per_wilayah)->
        where('tgl_terjadi','=',$request->tanggal)->
        first();

        // dd($cek_data,$request,$id);
        if ($cek_data==null) {
            $input_data = DataBencanaPerWilayah::create([
                'id_bencana_per_wilayah' => $request->id_bencana_per_wilayah,
                'jumlah' => $request->jumlah,
                'tgl_terjadi' => $request->tanggal,
            ]);
            if ($input_data) {
                return redirect()->back()->with('sukses','Data Sukses Dimasukkan');
            }
            else{
                return redirect()->back()->with('sukses','Data Gagal Dimasukkan');
            }
        }
        else{
            $update_data = DataBencanaPerWilayah::
            where('id_bencana_per_wilayah','=',$request->id_bencana_per_wilayah)->
            where('tgl_terjadi','=',$request->tanggal)->
            update([
                'jumlah' => $cek_data->jumlah+$request->jumlah,
            ]);
            if ($update_data) {
                return redirect()->back()->with('sukses','Data Sukses Diupdate');
            }
            else{
                return redirect()->back()->with('sukses','Data Gagal Diupdate');
            }
        }
    }

    public function ubah_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        $update_data = DataBencanaPerWilayah::
        where('id_bencana_per_wilayah','=',$request->id_bencana_per_wilayah)->
        where('tgl_terjadi','=',$request->tanggal)->
        update([
            'jumlah' => $request->jumlah,
        ]);
        if ($update_data) {
            return redirect()->back()->with('sukses','Data Sukses Diupdate');
        }
        else{
            return redirect()->back()->with('sukses','Data Gagal Diupdate');
        }
    }
    public function delete_wilayah(Request $request,$id)
    {
        // dd($request,$id);
        $hapus_data = DataBencanaPerWilayah::
        where('id_bencana_per_wilayah','=',$request->id_bencana_per_wilayah)->
        where('tgl_terjadi','=',$request->tanggal)->
        delete();
        if ($hapus_data) {
            return redirect()->back()->with('sukses','Data Sukses Dihapus');
        }
        else{
            return redirect()->back()->with('sukses','Data Gagal Dihapus');
        }
    }
}
