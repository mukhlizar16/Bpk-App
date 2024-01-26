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
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagu_id')
                ->index()
                ->constrained('pagu')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('pengadaan_id')
                ->index()
                ->constrained('jenis_pengadaan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('penyedia');
            $table->string('nomor');
            $table->date('tanggal');
            $table->integer('nilai_kontrak');
            $table->integer('jangka_waktu');
            $table->enum('bukti', [1, 0])->default(0);
            $table->integer('hps');
            $table->string('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
