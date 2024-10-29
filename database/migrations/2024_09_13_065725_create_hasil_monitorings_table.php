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
            $table->foreignId('jadwal_monitoring_id')->constrained('jadwal_monitorings')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');

            $table->float('hadir')->nullable();
            $table->float('izin')->nullable();
            $table->float('alpa')->nullable();
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
