<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tditemkeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthitemkeluar',
        'id_produk',
        'qty',
        'harga',
        'subtotal',
        'id_cabang',
        'is_delete'
    ];
}
