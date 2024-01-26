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
        Schema::create('realisasi_keuangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagu_id')
                ->index()
                ->constrained('pagu')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('nilai');
            $table->decimal('bobot', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_keuangan');
    }
};
