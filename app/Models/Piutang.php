<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'pembayaran',
        'sisa_piutang',
        'keterangan',
        'metode_pembayaran_id',
        'tanggal',
        'jumlah_piutang'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class);
    }
}
