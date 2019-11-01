<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['no_invoice', 'id', 'qty', 'harga', 'status', 
            'tgl_transaksi', 'ttl_harga','no_rekap', 'jenis', 'id_racik'];
}
