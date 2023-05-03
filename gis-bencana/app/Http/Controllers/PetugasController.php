<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Wilayah;

class PetugasController extends Controller
{
    public function petugas()
    {
        if (Auth()->User()->role!='Petugas') {
            return redirect('/');
        }
        $data = [
            'wilayah'=>Wilayah::all(),
        ];
        return view('Petugas.index',compact('data'));
    }
}