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
        'total',
        'potongan',
        'total_akhir',
        'tanggal',
        'id_cabang',
        'is_delete'
    ];
}
