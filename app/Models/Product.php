<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'satuan',
        'harga_jual',
        'qty',
        'hrg_beli',
        'total',
    ];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'product_id');
    }
}
