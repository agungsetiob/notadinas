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
        Schema::create('nota_pengiriman_lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_pengiriman_id')->constrained('nota_pengirimen')->onDelete('cascade');
            $table->foreignId('nota_lampiran_id')->constrained('nota_lampirans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_pengiriman_lampiran');
    }
};
