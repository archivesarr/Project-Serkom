<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'harga_produk',
        'stok_produk',
    ];
}
