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
        Schema::create('subkegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')
                ->index()
                ->constrained('kegiatan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('kode');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkegiatan');
    }
};
