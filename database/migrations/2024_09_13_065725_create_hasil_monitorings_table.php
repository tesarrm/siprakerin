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
        Schema::create('hasil_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_id')->constrained('monitorings')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->float('kedisiplinan')->nullable();
            $table->float('sikap')->nullable();
            $table->float('kerjasama')->nullable();
            $table->longText('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_monitorings');
    }
};
