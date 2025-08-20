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
            $table->foreignId('iot_id')->nullable();
            $table->foreignId('lapak_id')->nullable();
            $table->foreignId('ternak_id')->nullable();
            $table->float('jumlah');
            $table->string('waktu_kirim');
            $table->string('waktu_selesai_kirim')->nullable();
            $table->string('status_kirim');
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
