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
        Schema::create('biodata_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            // $table->string('nama_lengkap')->nullable();
            // $table->string('nama')->nullable();
            // $table->string('nis')->nullable();
            // $table->string('nisn')->nullable();
            // $table->string('tempat_lahir')->nullable();
            // $table->date('tanggal_lahir')->nullable();
            // $table->string('agama')->nullable();
            // $table->text('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            // $table->string('no_hp')->nullable();
            // $table->string('jenis_kelamin')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->string('hobi')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('organisasi')->nullable();
            $table->string('tahun_awal_1')->nullable();
            $table->string('tahun_akhir_1')->nullable();
            $table->string('tempat_1')->nullable();
            $table->string('berijasah_1')->nullable();
            $table->string('tahun_awal_2')->nullable();
            $table->string('tahun_akhir_2')->nullable();
            $table->string('tempat_2')->nullable();
            $table->string('berijasah_2')->nullable();
            $table->string('tahun_awal_3')->nullable();
            $table->string('tahun_akhir_3')->nullable();
            $table->string('tempat_3')->nullable();
            $table->string('berijasah_3')->nullable();
            $table->string('ayah_nama')->nullable();
            $table->string('ibu_nama')->nullable();
            $table->string('ayah_usia')->nullable();
            $table->string('ibu_usia')->nullable();
            $table->string('ayah_pendidikan_terakhir')->nullable();
            $table->string('ibu_pendidikan_terakhir')->nullable();
            $table->string('ayah_pekerjaan')->nullable();
            $table->string('ibu_pekerjaan')->nullable();
            $table->text('ayah_alamat')->nullable();
            $table->text('ibu_alamat')->nullable();
            $table->string('ayah_no_telp')->nullable();
            $table->string('ibu_no_telp')->nullable();
            $table->string('nama_0')->nullable();
            $table->text('alamat_0')->nullable();
            $table->string('no_telp_0')->nullable();
            $table->string('hub_keluarga_0')->nullable();
            $table->string('nama_1')->nullable();
            $table->text('alamat_1')->nullable();
            $table->string('no_telp_1')->nullable();
            $table->string('hub_keluarga_1')->nullable();
            $table->string('nama_2')->nullable();
            $table->text('alamat_2')->nullable();
            $table->string('no_telp_2')->nullable();
            $table->string('hub_keluarga_2')->nullable();
            $table->string('penyakit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata_siswas');
    }
};
