<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'kota';
    protected $fillable = [
        'provinsi_id', 'kota_id','nama'
    ];
}
