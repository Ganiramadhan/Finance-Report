<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonversiKas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_konversi_kas',
        'metode_pembayaran_id',
        'keterangan',
        'jumlah',
        'biaya_adm',
        'tanggal'
    ];

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
