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
        Schema::create('porsi_jp_tmo', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('jenis_tmo', 100);
            $table->string('penerima_jp', 100);
            $table->decimal('porsi_jp', 5, 2); // persentase
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porsi_jp_tmo');
    }
};
