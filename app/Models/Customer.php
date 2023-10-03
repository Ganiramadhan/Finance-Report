<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'saldo_awal_piutang',
        'alamat',
        'no_telepon'
    ];

    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
}
