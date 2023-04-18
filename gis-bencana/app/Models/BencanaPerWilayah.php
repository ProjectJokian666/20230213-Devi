<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BencanaPerWilayah extends Model
{
    use HasFactory;
    protected $table = 'bencana_per_wilayah';
    protected $primaryKey = 'id_bencana_per_wilayah';
    protected $fillable = [
        'id_bencana',
        'id_wilayah',
    ];

    public function bencana()
    {
        return $this->belongsTo(Bencana::class,'id_bencana','id');
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class,'id_wilayah','id');
    }
    public function data_per_wilayah()
    {
        return $this->hasMany(DataBencanaPerWilayah::class,'id_bencana_per_wilayah','id_bencana_per_wilayah');
    }
}
