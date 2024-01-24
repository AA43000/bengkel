<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'negara',
        'telephone',
        'fax',
        'kontak_person',
        'note',
        'id_cabang',
        'is_delete'
    ];
}
