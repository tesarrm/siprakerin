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
        Schema::create('hasil_monitoring_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_monitoring_id')->constrained('jadwal_monitorings')->onDelete('cascade');
            $table->text('gambar'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_monitoring_images');
    }
};
