<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBencanaPerWilayah extends Model
{
    use HasFactory;
    protected $table = 'data_bencana_per_wilayah';
    protected $fillable = [
        'id_bencana_per_wilayah',
        'jumlah',
        'tgl_terjadi',
    ];

    public function per_wilayah()
    {
        return $this->belongsTo(BencanaPerWilayah::class,'id_bencana_per_wilayah','id_bencana_per_wilayah');
    }
}
