<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('paket_id');
            $table->foreign('paket_id')->references('id')->on('pakets');
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('id')->on('prices');
            $table->enum ('status_pesanan', ['menunggu_konfirmasi', 'dikonfirmasi', 'selesai'])->default('menunggu_konfirmasi');
            $table->double('berat')->default(0);
            $table->double('total_harga')->default(0);
            $table->string('snap_token')->default(0);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('tanggal_pesanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
