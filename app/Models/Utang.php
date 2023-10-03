<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utang extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'utang',
        'pembayaran',
        'sisa_utang',
        'keterangan',
        'metode_pembayaran_id',
        'tanggal',
        'jumlah_utang'

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
