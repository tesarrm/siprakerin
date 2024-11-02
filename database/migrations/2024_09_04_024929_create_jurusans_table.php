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
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_keahlian_id')->constrained('bidang_keahlians')->onDelete('cascade');
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();

            $table->string('nama');
            $table->string('singkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
