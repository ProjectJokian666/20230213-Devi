<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function petugas()
    {
        if (Auth()->User()->role!='Petugas') {
            return redirect('/');
        }
        return view('Petugas.index');
    }
}