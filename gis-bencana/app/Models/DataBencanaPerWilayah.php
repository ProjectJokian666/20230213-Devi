<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wilayah;
use App\Models\Bencana;

class DataBencanaPerWilayah extends Model
{
    use HasFactory;
    protected $table = 'data_bencana_per_wilayah';
    protected $fillable = [
        'id_bencana_per_wilayah',
        'jumlah',
        'deskripsi',
        'tgl_terjadi',
    ];

    public function per_wilayah()
    {
        return $this->belongsTo(BencanaPerWilayah::class,'id_bencana_per_wilayah','id_bencana_per_wilayah');
    }
    public function nama_wilayah($id)
    {
        return Wilayah::find($id);
    }
    public function nama_bencana($id)
    {
        return Bencana::find($id);
    }
}
