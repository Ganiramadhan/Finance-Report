<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konversi_kas', function (Blueprint $table) {
            $table->id();
            $table->string('kd_konversi_kas');
            $table->integer('metode_pembayaran_id');
            $table->string('keterangan');
            $table->integer('jumlah');
            $table->integer('biaya_adm');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konversi_kas');
    }
};
