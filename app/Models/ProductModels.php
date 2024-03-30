<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModels extends Model
{
    use HasFactory;
    protected $table = 'product_models';
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'jumlah_produk',
        'harga_produk',
        'kategori',
        'status'
    ];
}
