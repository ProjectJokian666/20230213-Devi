<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class PetugasController extends Controller
{
    public function petugas()
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = [
                'user' => User::where('role','=','Petugas')->get(),
            ];
            return view('Admin.petugas.index',compact('data'));
        }
        else{
            return redirect('login');
        }
    }

    public function add_petugas(Request $request)
    {
        // dd($request);
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Petugas',
            ]);
            if ($data) {
                return redirect('admin/petugas')->with('sukses','Data berhasil ditambahkan');
            }
            else{
                return redirect('admin/petugas')->with('gagal','Data gagal ditambahkan');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function update_petugas(Request $request)
    {
        // dd($request);
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            if ($request->password!=null) {
                $data = User::where('id','=',$request->id)->update([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'Petugas',
                ]);
            }
            if ($request->password==null) {
                $data = User::where('id','=',$request->id)->update([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'role' => 'Petugas',
                ]);
            }
            if ($data) {
                return redirect('admin/petugas')->with('sukses','Data berhasil diubah');
            }
            else{
                return redirect('admin/petugas')->with('gagal','Data gagal diubah');
            }
        }
        else{
            return redirect('login');
        }
    }

    public function delete_petugas(Request $request)
    {
        if (Auth::check()) {
            if (Auth()->User()->role!='Admin') {
                return redirect('/');
            }
            $data = User::where('id','=',$request->id)->delete();
            if ($data) {
                return redirect('admin/petugas')->with('sukses','Data berhasil dihapus');
            }
            else{
                return redirect('admin/petugas')->with('gagal','Data gagal dihapus');
            }
        }
        else{
            return redirect('login');
        }
    }
}
