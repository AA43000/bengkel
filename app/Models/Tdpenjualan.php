<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdpenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthpenjualan',
        'id_produk',
        'pesan',
        'qty',
        'harga',
        'subtotal',
        'is_delete'
    ];
}
