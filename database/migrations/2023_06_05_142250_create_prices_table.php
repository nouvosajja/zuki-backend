<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('waktu');
            $table->unsignedBigInteger('paket_id');
            $table->integer('harga');
            $table->string('deskripsi');
            $table->string('images')->default("");
            $table->foreign('paket_id')->references('id')->on('pakets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
