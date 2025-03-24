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
        Schema::create('rph', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alamat');
            $table->string('phone')->nullable();
            $table->enum('status_sertifikasi', ['sudah', 'belum']);
            $table->string('file_sertifikasi')->nullable();
            $table->string('waktu_upload')->nullable();
            $table->foreignId('penyelia_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
