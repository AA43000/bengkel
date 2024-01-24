<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdpembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthpembelian',
        'id_produk',
        'pesan',
        'qty',
        'harga',
        'subtotal',
        'id_cabang',
        'is_delete'
    ];
}
