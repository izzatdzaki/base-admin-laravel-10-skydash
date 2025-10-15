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
        Schema::create('tarif', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tarif', 50)->unique();
            $table->string('kode', 20);
            $table->string('instansi', 100);
            $table->string('instansi_pelaksana', 100);
            $table->string('kelompok_tindakan', 100);
            $table->string('nama_tindakan', 255);
            $table->text('detail_tindakan')->nullable();
            $table->decimal('js', 15, 2)->default(0);
            $table->decimal('jp', 15, 2)->default(0);
            $table->decimal('tarif', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif');
    }
};