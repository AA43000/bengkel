<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thtukartambah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'id_pelanggan',
        'total',
        'tanggal',
        'id_cabang',
        'is_delete'
    ];
}
