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
        Schema::create('paramedis_pendamping', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tarif', 20)->unique();
            $table->string('nama_pendamping', 100);
            $table->string('ruang_unit', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paramedis_pendamping');
    }
};
