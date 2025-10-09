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
        Schema::create('tbl_tarif', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tarif', 50)->unique();
            $table->string('nama_tarif', 100);
            $table->string('instalasi', 100);
            $table->string('instalasi_pelaksana', 100);
            $table->string('kode_klp', 50);
            $table->string('klp_tindakan', 100);
            $table->string('nama_tindakan', 100);
            $table->string('biaya', 50);
            $table->string('jasa', 50);
            $table->string('tarif', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_tarif');
    }
};
