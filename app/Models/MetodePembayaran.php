<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'metode_pembayaran',
    ];

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }

    public function jenis_transaksi()
    {
        return $this->hasOne(JenisTransaksi::class);
    }
}
