<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'produk';

    protected $fillable = ['nama','gambar','deskripsi','harga','weigth','kategori_id','stok'];
}
