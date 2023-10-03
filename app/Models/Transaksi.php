<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_transaksi',
        'jenis_transaksi_id',
        'metode_pembayaran_id',
        'keterangan',
        'jumlah',
        'biaya_adm',
        'tanggal',
        'jenis_transaksi',
        'metode_pembayaran',
        'saldo',
    ];

    public function jenis_transaksi()
    {
        return $this->belongsTo(JenisTransaksi::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}