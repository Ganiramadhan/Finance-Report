<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [

        'nama',
        'hrg_jual',
        'stok',
        'hrg_beli',
        'total_harga',
        'satuan',
        'tanggal'
    ];
}
