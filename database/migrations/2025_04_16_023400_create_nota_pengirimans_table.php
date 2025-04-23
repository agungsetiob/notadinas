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
        Schema::create('nota_pengirimen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_dinas_id')->constrained('nota_dinas')->onDelete('cascade');
            $table->enum('dikirim_dari', ['skpd', 'asisten', 'sekda', 'bupati']);
            $table->enum('dikirim_ke', ['asisten', 'sekda', 'bupati', 'skpd']);
            $table->foreignId('pengirim_id')->constrained('users');
            $table->timestamp('tanggal_kirim')->useCurrent();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_pengirimans');
    }
};
