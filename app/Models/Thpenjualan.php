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
        'total',
        'potongan',
        'total_akhir',
        'tanggal',
        'is_delete'
    ];
}
