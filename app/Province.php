<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinsi';
    protected $fillable = [
        'provinsi_id', 'title'
    ];
}
