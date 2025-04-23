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
        Schema::create('nota_persetujuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_dinas_id')->constrained('nota_dinas')->onDelete('cascade');
            $table->foreignId('approver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('skpd_id')->constrained('skpds')->onDelete('cascade')->comment('SKPD pemilik nota dinas');
            $table->enum('role_approver', ['asisten', 'sekda', 'bupati'])->comment('Peran pemberi persetujuan');
            $table->unsignedTinyInteger('urutan')->comment('Urutan persetujuan dalam proses');
            $table->enum('status', ['disetujui', 'ditolak'])->default('disetujui');
            $table->text('catatan_terakhir')->nullable()->comment('Catatan dari pemberi persetujuan');
            $table->timestamp('tanggal_update')->nullable()->comment('Waktu terakhir pembaruan status');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_persetujuans');
    }
};
