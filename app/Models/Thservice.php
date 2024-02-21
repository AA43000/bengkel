<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thservice extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'no_plat',
        'id_mekanik',
        'total_bayar',
        'kembalian',
        'pembayaran',
        'total_akhir',
        'tanggal',
        'id_cabang',
        'id_user',
        'is_delete',
        'status'
    ];
}
