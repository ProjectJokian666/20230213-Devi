<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function wilayah()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = [
                'wilayah' => Wilayah::all(),
            ];
            return view('Admin.wilayah.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function add_wilayah(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            if ($request->file('file_wilayah')==null) {
                return redirect('admin/wilayah')->with('gagal','Data gagal ditambahkan');
            }
            //get data file
            $file_wilayah = $request->file('file_wilayah');
            //nama file
            $nama_file_wilayah = DATE('YmdHis').'.'.$file_wilayah->getClientOriginalExtension();
            $file_wilayah->move('Data_Wilayah',$nama_file_wilayah);

            $data = Wilayah::create([
                'nama_wilayah' => $request->wilayah,
                'file_wilayah' => $nama_file_wilayah,
            ]);
            if ($data) {
                return redirect('admin/wilayah')->with('sukses','Data berhasil ditambahkan');
            }
            else{
                return redirect('admin/wilayah')->with('gagal','Data gagal ditambahkan');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function update_wilayah(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
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
                return redirect('admin/wilayah')->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('admin/wilayah')->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function delete_wilayah(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = Wilayah::where('id','=',$request->id)->delete();
            if ($data) {
                return redirect('admin/wilayah')->with('sukses','Data berhasil dihapus');
            }
            else{
                return redirect('admin/wilayah')->with('gagal','Data gagal dihapus');
            }
        }
        else{
            return redirect('login');
        }
    }
}
