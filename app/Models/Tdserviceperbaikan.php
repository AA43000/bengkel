<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdserviceperbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthservice',
        'bagian',
        'keterangan',
        'is_delete'
    ];
}
