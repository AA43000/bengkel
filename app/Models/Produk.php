<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_item',
        'kode_barcode',
        'nama_item',
        'jenis',
        'kategori',
        'stok',
        'satuan',
        'rak',
        'harga_pokok',
        'harga_jual',
        'id_cabang',
        'is_delete'
    ];
}
