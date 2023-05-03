<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Wilayah;

class AdminController extends Controller
{
    public function admin()
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('/');
        }
        $data = [
            'wilayah'=>Wilayah::all(),
        ];
        return view('Admin.index',compact('data'));
    }
}
