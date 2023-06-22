<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenController extends Controller
{
	public function login()
	{
		if (Auth::check()) {
			return redirect('/');
		}
		else{
			return view('guest.login');
		}
	}
	public function plogin(Request $request)
	{
		$data = User::where('email',$request->email)->first();
		if ($data==null) {
			return redirect('login');
		}
		if ($data->role=='Admin') {
			if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'role'=>'Admin'])){
				$request->session()->regenerate();
				return redirect()->intended('admin');
			}
			Auth::logout();
			return redirect('login');
		}
		else if ($data->role=='Petugas') {
			if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'role'=>'Petugas'])){
				$request->session()->regenerate();
				return redirect()->intended('petugas');
			}
			Auth::logout();
			return redirect('login');
		}
	}
	public function logout()
	{
		Auth::logout();
		return redirect('login');
	}
	public function profil()
	{
		if (Auth()->User()->role=='Admin') {
			return view('Admin.profil');
		}
		if (Auth()->User()->role=='Petugas') {
			return view('Petugas.profil');
		}
	}
	public function pprofil(Request $request)
	{
		if ($request->password!=null) {
			if ($request->file('img_profil')) {
				$get_data = User::find(Auth()->User()->id);
				if ($get_data->foto==null) {
					$file_img = $request->file('img_profil');
					$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
					$move_file = $file_img->move('Img',$nama_file_img);
					if ($move_file) {
						$data = User::where('id','=',Auth()->User()->id)->update([
							'name' => $request->name,
							'email' => $request->email,
							'password' => Hash::make($request->password),
							'foto' => $nama_file_img,
						]);
					}
				}
				else if($get_data->foto){
					if (file_exists("Img/".$get_data->foto)) {
						$hapus_file_img = unlink("Img/".$get_data->foto);
						if($hapus_file_img){
							$file_img = $request->file('img_profil');
							$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
							$move_file = $file_img->move('Img',$nama_file_img);
							if ($move_file) {
								$data = User::where('id','=',Auth()->User()->id)->update([
									'name' => $request->name,
									'email' => $request->email,
									'password' => Hash::make($request->password),
									'foto' => $nama_file_img,
								]);
							}
						}
					}
					else{
						$file_img = $request->file('img_profil');
						$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
						$move_file = $file_img->move('Img',$nama_file_img);
						if ($move_file) {
							$data = User::where('id','=',Auth()->User()->id)->update([
								'name' => $request->name,
								'email' => $request->email,
								'password' => Hash::make($request->password),
								'foto' => $nama_file_img,
							]);
						}						
					}
				}
			}
			else{
				$data = User::where('id','=',Auth()->User()->id)->update([
					'name' => $request->name,
					'email' => $request->email,
					'password' => Hash::make($request->password),
				]);
			}
		}
		if ($request->password==null) {
			// dd($request->file('img_profil'));
			if ($request->file('img_profil')) {
				$get_data = User::find(Auth()->User()->id);
				if ($get_data->foto==null) {
					$file_img = $request->file('img_profil');
					$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
					$move_file = $file_img->move('Img',$nama_file_img);
					if ($move_file) {
						$data = User::where('id','=',Auth()->User()->id)->update([
							'name' => $request->name,
							'email' => $request->email,
							'foto' => $nama_file_img,
						]);
					}
				}
				else if($get_data->foto){
					if (file_exists("Img/".$get_data->foto)) {
						$hapus_file_img = unlink("Img/".$get_data->foto);
						if($hapus_file_img){
							$file_img = $request->file('img_profil');
							$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
							$move_file = $file_img->move('Img',$nama_file_img);
							if ($move_file) {
								$data = User::where('id','=',Auth()->User()->id)->update([
									'name' => $request->name,
									'email' => $request->email,
									'foto' => $nama_file_img,
								]);
							}
						}
					}
					else{
						$file_img = $request->file('img_profil');
						$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
						$move_file = $file_img->move('Img',$nama_file_img);
						if ($move_file) {
							$data = User::where('id','=',Auth()->User()->id)->update([
								'name' => $request->name,
								'email' => $request->email,
								'foto' => $nama_file_img,
							]);
						}						
					}
				}
			}
			else{
				$data = User::where('id','=',Auth()->User()->id)->update([
					'name' => $request->name,
					'email' => $request->email,
				]);
			}
			// dd($request);
		}
		// dd($data);
		if ($data) {
			Auth::logout();
			$data_user = User::where('email',$request->email)->first();
			if ($data_user->role=='Admin') {
				if(Auth::attempt(['email'=>$data_user->email,'password'=>$data_user->password,'role'=>'Admin'])){
					$data_user->session()->regenerate();
					return redirect()->intended('profil');
				}
				Auth::logout();
				return redirect('login');
			}
			else if ($data_user->role=='Petugas') {
				if(Auth::attempt(['email'=>$data_user->email,'password'=>$data_user->password,'role'=>'Petugas'])){
					$data_user->session()->regenerate();
					return redirect()->intended('profil');
				}
				Auth::logout();
				return redirect('login');
			}
		}
		else{
			return redirect('profil');
		}
	}
	public function pprofil_img(Request $request)
	{
		// dd($request);
		if (Auth::check()) {

			
			if ($request->file('img_profil')) {
				$get_data = User::find(Auth()->User()->id);
				// dd($get_data);
				//null img
				if ($get_data->foto==null) {
					$file_img = $request->file('img_profil');
					$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
					$move_file = $file_img->move('Img',$nama_file_img);
					if ($move_file) {
						$update_file = User::where('id','=',Auth()->User()->id)->update([
							'foto' => $nama_file_img,
						]);
					}
				}
				else if($get_data->foto){
					if (file_exists("Img/".$get_data->foto)) {
						$hapus_file_img = unlink("Img/".$get_data->foto);
						if($hapus_file_img){
							$file_img = $request->file('img_profil');
							$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
							$move_file = $file_img->move('Img',$nama_file_img);
							if ($move_file) {
								$update_file = User::where('id','=',Auth()->User()->id)->update([
									'foto' => $nama_file_img,
								]);
							}
						}
					}
					else{
						$file_img = $request->file('img_profil');
						$nama_file_img = DATE('YmdHis').'.'.$file_img->getClientOriginalExtension();
						$move_file = $file_img->move('Img',$nama_file_img);
						if ($move_file) {
							$update_file = User::where('id','=',Auth()->User()->id)->update([
								'foto' => $nama_file_img,
							]);
						}						
					}
				}
				if ($update_file) {
					return redirect('profil')->with('sukses','Data berhasil diubah');
				}
				else {
					return redirect('profil')->with('gagal','Data gagal diubah');
				}
			}


			return redirect()->route('profil');
		}
		else{
			return redirect('login');
		}
	}
}
