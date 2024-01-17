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
        'is_delete'
    ];
}