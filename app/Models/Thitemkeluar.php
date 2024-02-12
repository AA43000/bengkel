<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thitemkeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'total',
        'keterangan',
        'tanggal',
        'total_qty',
        'created_by',
        'id_cabang',
        'id_user',
        'is_delete'
    ];
}
