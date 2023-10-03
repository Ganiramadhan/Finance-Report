<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_transaksi',
        'product_id',
        'qty',
        'total_harga',
        'metode_pembayaran_id',
        'supplier_id',
        'total_belanja',
        'diskon',
        'total_bayar',
        'pembayaran',
        'utang',
        'tanggal',
        'satuan',
        'hrg_beli_satuan',
        'hrg_jual_satuan',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
