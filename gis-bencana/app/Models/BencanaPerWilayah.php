<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DataBencanaPerWilayah;
use App\Models\BencanaPerWilayah;

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
    public function terdampak($id,$bencana)
    {   
        $dampak = 0;
        $data = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$id)->get();
        foreach($data as $key => $value){
            $dampak+=$value['jumlah'];
        }

        $semua = 0;
        $total_bencana = BencanaPerWilayah::where('id_bencana','=',$bencana)->get();
        // dd($total_bencana);
        foreach ($total_bencana as $key => $value) {
            $jumlah_bencana = DataBencanaPerWilayah::where('id_bencana_per_wilayah','=',$value['id_bencana_per_wilayah'])->get();
            // dd($jumlah_bencana);
            foreach ($jumlah_bencana as $key_jb => $value_jb) {
                $semua+=$value_jb['jumlah'];
            }
        }
        // return $dampak.",".$bencana.",".$id.",".$semua;
        $hasil = 0;
        if ($dampak!=0) {
            $hasil = $dampak/$semua*100;
        }
        return round($hasil);

    }
}
