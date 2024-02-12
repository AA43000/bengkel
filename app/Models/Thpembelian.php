<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thpembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'id_supplier',
        'no_pesanan',
        'pembayaran',
        'total_bayar',
        'sisa_bayar',
        'total_akhir',
        'tanggal',
        'id_cabang',
        'id_user',
        'is_delete'
    ];
}
