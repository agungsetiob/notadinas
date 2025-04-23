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
        Schema::table('nota_lampirans', function (Blueprint $table) {
            $table->foreignId('nota_pengiriman_id')->nullable()->constrained()->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nota_lampiran', function (Blueprint $table) {
            $table->dropForeign(['nota_pengiriman_id']);
            $table->dropColumn('nota_pengiriman_id');
        });
    }
};
