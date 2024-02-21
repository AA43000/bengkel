<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'keahlian',
        'alamat',
        'kota',
        'provinsi',
        'telephone',
        'note',
        'id_cabang',
        'is_delete',
        'id_user'
    ];
}
