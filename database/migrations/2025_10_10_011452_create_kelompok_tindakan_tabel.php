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
        Schema::create('kelompok_tindakan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tindakan', 50)->unique();
            $table->string('kode_tarif', 20);
            $table->string('instalasi_induk', 100);
            $table->string('instansi_pelaksana', 100);
            $table->string('unit', 100);
            $table->string('kelompok_tindakan', 100);
            $table->text('detail_tindakan')->nullable();
            $table->text('rincian_tindakan')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_tindakan');
    }
};
