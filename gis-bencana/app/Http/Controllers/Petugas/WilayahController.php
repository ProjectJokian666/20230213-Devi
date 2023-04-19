<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function wilayah()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }
            $data = [
                'wilayah' => Wilayah::all(),
            ];
            return view('Petugas.wilayah.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function update_wilayah(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Petugas') {
                return redirect('/');
            }
            // dd($request);
            if ($request->file('file_wilayah')) {
                // dd($request->file('file_wilayah'));
                //get data file
                $file_wilayah = $request->file('file_wilayah');
            //nama file
                $nama_file_wilayah = DATE('YmdHis').'.'.$file_wilayah->getClientOriginalExtension();
                $file_wilayah->move('Data_Wilayah',$nama_file_wilayah);

                $hapus_file = Wilayah::find($request->id);
                if (file_exists("Data_Wilayah/".$hapus_file->file_wilayah)) {
                    unlink("Data_Wilayah/".$hapus_file->file_wilayah);
                }
                $data = Wilayah::where('id','=',$request->id)->update([
                    'nama_wilayah' => $request->wilayah,
                    'file_wilayah' => $nama_file_wilayah,
                ]);
            }
            if ($request->file('file_wilayah')==null) {
                // dd($request,'ok');
                $data = Wilayah::where('id','=',$request->id)->update([
                    'nama_wilayah' => $request->wilayah,
                ]);
            }
            if ($data) {
                return redirect('petugas/wilayah')->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('petugas/wilayah')->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }
}