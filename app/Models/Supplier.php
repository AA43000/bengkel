<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
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
        'bank',
        'no_account',
        'atas_nama',
        'kontak_person',
        'email',
        'is_delete'
    ];
}
