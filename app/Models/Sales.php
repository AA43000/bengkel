<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'komisi',
        'komisi_nominal',
        'alamat',
        'kota',
        'telephone',
        'is_delete',
    ];
}
