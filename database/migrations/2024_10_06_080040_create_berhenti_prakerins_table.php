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
        Schema::create('berhenti_prakerins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('industri_lama_id')->constrained('industris')->onDelete('cascade');
            $table->foreignId('industri_baru_id')->nullable()->constrained('industris')->onDelete('cascade');
            $table->string('tanggal_berhenti')->nullable();
            $table->string('tanggal_lanjut')->nullable();
            $table->text('alasan_berhenti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berhenti_prakerins');
    }
};
