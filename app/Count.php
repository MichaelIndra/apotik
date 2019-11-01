<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Count extends Model
{
    protected $fillable = ['tipe', 'count', 'created_at', 'updated_at'];
    protected $dates = ['updated_at'];
}

