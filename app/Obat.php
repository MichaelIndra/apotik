<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = ['obat_id', 'nama_obat', 'keterangan', 'perusahaan', 'jenis', 'kategori', 'status', 'penggunaan'];
    public function hargaobats(){
        return $this->hasMany('App\HargaObat', 'obat_id');
    }
}
