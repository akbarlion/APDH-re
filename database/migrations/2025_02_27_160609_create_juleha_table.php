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
        Schema::create('juleha', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->string('masa_sertifikat')->nullable();
            $table->string('upload_sertifikat')->nullable();
            $table->string('waktu_upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juleha');
    }
};
