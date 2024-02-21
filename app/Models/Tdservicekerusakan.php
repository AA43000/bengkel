<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdservicekerusakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'idthservice',
        'bagian',
        'kerusakan',
        'is_delete'
    ];
}
