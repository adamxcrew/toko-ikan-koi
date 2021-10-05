<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    protected $table = 'kurir';
    protected $fillable = [
        'kode', 'nama'
    ];
}
