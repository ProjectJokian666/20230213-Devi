<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wilayah;

class PetaController extends Controller
{
    public function peta()
    {   
        $data = [
            'wilayah'=>Wilayah::all(),
        ];
        return view('guest.peta.index',compact('data'));
    }
}
