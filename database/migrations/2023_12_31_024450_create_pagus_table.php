<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subkegiatan_id')->constrained('subkegiatans')->onUpdate('cascade')->onDelete('restrict');
            $table->string('paket');
            $table->foreignId('sumber_dana_id')->constrained('sumber_danas')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('jumlah');
            $table->foreignId('pengadaan_id')->constrained('jenis_pengadaans')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagu');
    }
};
