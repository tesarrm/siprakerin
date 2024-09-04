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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->text('gambar')->nullable();
            $table->string('nip')->nullable();
            $table->string('nama_guru')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('peran', ['Admin', 'Kepala Bengkel', 'Siswa'])->nullable();
            $table->string('wali_kelas')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
            // $table->foreignIdFor(Peserta::class, 'id_peserta');
            // $table->foreign('id_peserta')->references($peserta->getKeyName())->on($peserta->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
