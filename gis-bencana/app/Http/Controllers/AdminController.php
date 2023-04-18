<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin()
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('/');
        }
        return view('Admin.index');
    }
}
