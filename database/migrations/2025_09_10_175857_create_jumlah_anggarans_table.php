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
        Schema::create('jumlah_anggarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatan_utama_id')->nullable();
            $table->unsignedBigInteger('sub_kegiatan_id')->nullable();
            $table->decimal('jumlah', 20, 2)->default(0);
            $table->timestamps();

            $table->foreign('kegiatan_utama_id')->references('id')->on('kegiatan_utamas')->onDelete('cascade');
            $table->foreign('sub_kegiatan_id')->references('id')->on('sub_kegiatans')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_anggarans');
    }
};
