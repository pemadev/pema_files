<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Permohonan informasi publik (pemohon)
        Schema::create('ppid_permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi', 50)->unique();
            $table->string('nama');
            $table->string('nik', 20)->nullable();
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kategori_pemohon', 30)->default('perorangan'); // perorangan | badan_hukum | kelompok
            $table->text('rincian_informasi');
            $table->text('tujuan_penggunaan')->nullable();
            $table->string('cara_memperoleh', 50)->nullable();  // melihat | softcopy | hardcopy
            $table->string('cara_mendapatkan', 50)->nullable(); // email | langsung | pos
            $table->string('status', 30)->default('diproses');
            $table->text('catatan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('created_at');
            $table->index('email');
        });

        // Pengaduan layanan informasi
        Schema::create('ppid_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket', 50)->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('kategori', 50)->nullable(); // layanan | informasi | petugas | lainnya
            $table->string('subjek');
            $table->text('isi');
            $table->string('status', 30)->default('baru');
            $table->text('tanggapan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('created_at');
        });

        // Keberatan atas permohonan informasi (Pasal 35 UU 14/2008)
        Schema::create('ppid_keberatan', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi', 50)->unique();
            $table->foreignId('permohonan_id')->nullable()
                ->constrained('ppid_permohonan')->nullOnDelete();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('alasan', 5); // a - g
            $table->text('uraian');
            $table->string('status', 30)->default('diproses');
            $table->text('tanggapan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_keberatan');
        Schema::dropIfExists('ppid_pengaduan');
        Schema::dropIfExists('ppid_permohonan');
    }
};
