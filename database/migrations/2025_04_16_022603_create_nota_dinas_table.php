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
        Schema::create('nota_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained('skpds');
            $table->string('nomor_nota');
            $table->string('perihal');
            $table->string('anggaran');
            $table->date('tanggal_pengajuan');
            $table->enum('status', ['draft', 'proses', 'disetujui', 'ditolak', 'dikembalikan'])->default('draft');
            $table->enum('tahap_saat_ini', ['skpd', 'asisten', 'sekda', 'bupati', 'selesai'])->default('skpd');
            $table->foreignId('asisten_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_dinas');
    }
};
