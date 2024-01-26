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
        Schema::create('spmk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagu_id')
                ->index()
                ->constrained('pagu')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nomor');
            $table->date('tanggal');
            $table->string('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmk');
    }
};
