<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_pengeluaran_id',
        'penerima',
        'keterangan',
        'jml_pembayaran',
        'metode_pembayaran_id',
        'tanggal',
        'kd_pembayaran'
    ];

    public function kategori_pengeluaran()
    {
        return $this->belongsTo(KategoriPengeluaran::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
