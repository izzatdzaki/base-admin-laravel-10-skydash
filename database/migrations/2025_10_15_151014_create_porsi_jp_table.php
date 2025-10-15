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
        Schema::create('porsi_jp', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tarif', 20);
            $table->string('instalasi_induk', 100);
            $table->string('instansi_pelaksana', 100);
            $table->string('kelompok_tindakan', 100);
            $table->integer('jlp')->default(0); // Jasa Lainnya Pelayanan
            $table->integer('jla')->default(0); // Jasa Lainnya Administrasi
            $table->integer('jtl_st')->default(0); // Jasa Tambahan Lainnya - ST
            $table->integer('jtl_p')->default(0); // Jasa Tambahan Lainnya - P
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porsi_jp');
    }
};
