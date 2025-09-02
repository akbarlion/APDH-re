<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iot_id')->nullable();
            $table->foreignId('lapak_id')->nullable();
            $table->foreignId('ternak_id')->nullable();
            $table->foreignId('rph_id')->nullable();
            $table->float('jumlah');
            $table->string('waktu_kirim');
            $table->string('waktu_selesai_kirim')->nullable();
            $table->string('status_kirim');
            $table->timestamps();
        });
        // 2. Copy data from old table into temp table
        DB::statement("INSERT INTO transaksis_temp 
            (id, iot_id, lapak_id, ternak_id, rph_id, jumlah, waktu_kirim, waktu_selesai_kirim, status_kirim, created_at, updated_at)
        SELECT id, iot_id, lapak_id, ternak_id, NULL, jumlah, waktu_kirim, waktu_selesai_kirim, status_kirim, created_at, updated_at
        FROM transaksis");

        // 3. Drop old table
        Schema::dropIfExists('transaksis');
        Schema::rename('transaksis_temp', 'transaksis');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
