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
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('subject');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->enum('type', ['sistem', 'order'])->default('sistem');
            $table->integer('redirect_id')->nullable();
            $table->date('tanggal_inbox')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxes');
    }
};
