<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'nama',
        'telephone',
        'alamat',
        'logo',
        'is_delete'
    ];
}
