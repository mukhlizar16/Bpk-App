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
        Schema::create('baps', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->foreignId('pagu_id')->constrained('pagus')->onUpdate('cascade')->onDelete('restrict');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baps');
    }
};
