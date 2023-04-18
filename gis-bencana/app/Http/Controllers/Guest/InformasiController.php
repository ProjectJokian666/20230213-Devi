<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bencana;

class InformasiController extends Controller
{
    public function informasi()
    {
        $data = [
            'bencana' => Bencana::all(),
        ];
        return view('guest.informasi.index',compact('data'));
    }
}
