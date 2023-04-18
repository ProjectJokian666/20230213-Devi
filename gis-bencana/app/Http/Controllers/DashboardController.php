<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
            return view('guest.home');
        }
    }
}
