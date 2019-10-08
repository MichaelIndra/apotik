<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = ['obat_id', 'stok', 'tgl_transaksi', 'keterangan'];
}
