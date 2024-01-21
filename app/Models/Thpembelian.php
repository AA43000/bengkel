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
        'total',
        'potongan',
        'total_akhir',
        'tanggal',
        'is_delete'
    ];
}
