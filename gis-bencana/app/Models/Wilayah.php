<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;
    protected $table = 'wilayah';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_wilayah',
        'file_wilayah',
    ];

    public function bencanaperwilayah()
    {
        return $this->hasMany(BencanaPerWilayah::class,'id_wilayah','id');
    }
}
