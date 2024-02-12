<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thpenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'id_pelanggan',
        'total_bayar',
        'kembalian',
        'pembayaran',
        'total_akhir',
        'tanggal',
        'id_cabang',
        'id_user',
        'is_delete'
    ];
}
