<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'total_harga',
        'total_belanja',
        'diskon',
        'qty',
        'piutang',
        'total_bayar',
        'pembayaran',
        'metode_pembayaran_id',
        'no_faktur',
        'hrg_jual_satuan',
        'hrg_beli_satuan',
        'tanggal'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
