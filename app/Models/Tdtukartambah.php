<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdtukartambah extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthtukartambah',
        'id_produk',
        'qty',
        'harga',
        'subtotal',
        'potongan',
        'total',
        'id_cabang',
        'is_delete'
    ];
}
