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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kd_transaksi');
            $table->integer('product_id');
            $table->integer('qty');
            $table->integer('total_harga');
            $table->integer('metode_pembayaran_id');
            $table->integer('supplier_id');
            $table->integer('total_belanja');
            $table->integer('diskon');
            $table->integer('total_bayar');
            $table->integer('pembayaran');
            $table->integer('utang');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
