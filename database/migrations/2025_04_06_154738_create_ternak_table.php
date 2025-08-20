o<?php

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
        Schema::create('ternak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peternak_id')->nullable();
            $table->foreignId('juleha_id')->nullable();
            $table->foreignId('penyelia_id')->nullable();
            $table->foreignId('rph_id')->nullable();
            $table->string('img')->nullable();
            $table->float('karkas')->nullable();
            $table->string('jenis')->nullable();
            $table->string('kesehatan')->nullable();
            $table->string('waktu_sembelih')->nullable();
            $table->boolean('validasi_1')->nullable(); // Changed INTEGER to BOOLEAN for validation flags
            $table->boolean('validasi_2')->nullable(); // Changed INTEGER to BOOLEAN for validation flags
            $table->float('bobot')->nullable();
            $table->string('waktu_daftar')->nullable();
            $table->string('no_antri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternak');
    }
};
