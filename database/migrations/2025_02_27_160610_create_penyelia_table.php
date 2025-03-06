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
        Schema::create('penyelia', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete();
            $table->foreignId('rph_id')->constrained('rph_id')->cascadeOnDelete();
            $table->string('nip')->nullable();
            $table->string('status')->nullable();
            $table->date('tgl_berlaku')->nullable();
            $table->string('file_sk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyelia');
    }
};
