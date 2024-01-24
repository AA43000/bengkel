<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_polisi',
        'pemilik',
        'alamat',
        'merk',
        'tipe',
        'jenis',
        'tahun_buat',
        'tahun_rakit',
        'silinder',
        'warna',
        'no_rangka',
        'no_mesin',
        'id_cabang',
        'is_delete'
    ];
}
