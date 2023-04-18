<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bencana;
use App\Models\BencanaPerWilayah;
use App\Models\Wilayah;

class GrafikController extends Controller
{
    public function grafik()
    {   
        $data = [
            'Bencana' => Bencana::all(),
        ];
        return view('guest.grafik.index',compact('data'));
    }
}
