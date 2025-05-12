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
        Schema::table('ternak', function (Blueprint $table) {
            $table->foreignId('rph_id')->nullable()->constrained('rphs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ternak', function (Blueprint $table) {
            $table->dropForeign(['rph_id']);
            $table->dropColumn('rph_id');
        });
    }
};
