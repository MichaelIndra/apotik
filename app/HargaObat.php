<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HargaObat extends Model
{
    protected $fillable = ['obat_id', 'harga', 'kategori', 'tgl_awal', 'tgl_akhir'];
    public function obat(){
        $this->belongsTo('App\Obat','obat_id');
    }
}
