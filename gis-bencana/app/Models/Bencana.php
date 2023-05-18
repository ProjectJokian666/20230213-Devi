<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BencanaPerWilayah;

class Bencana extends Model
{
    use HasFactory;
    protected $table = 'bencana';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama_bencana',
        'deskripsi_bencana',
    ];

    public function bencanaperwilayah()
    {
        return $this->hasMany(BencanaPerWilayah::class,'id_bencana','id');
    }
    public function nama_wilayah($id)
    {
        return BencanaPerWilayah::find($id);
    }
}
