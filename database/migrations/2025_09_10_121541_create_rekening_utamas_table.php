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
        Schema::create('rekening_utamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_utama_id')->constrained('kegiatan_utamas')->onDelete('cascade');
            $table->string('no_rek', 20);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_utamas');
    }
};
