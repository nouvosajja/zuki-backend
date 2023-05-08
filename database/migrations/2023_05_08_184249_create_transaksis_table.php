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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_plgn');
            $table->unsignedBigInteger('id_pkt');
            $table->date('tgl_transaksi', 100);
            $table->string('status_transaksi', 100);
            $table->foreign('id_plgn')->references('id')->on('pelanggans');
            $table->foreign('id_pkt')->references('id')->on('pakets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
