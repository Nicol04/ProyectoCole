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
        Schema::create('listas_cotejo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesions')->onDelete('cascade');
            $table->foreignId('criterio_id')->nullable()->constrained('criterios_evaluacion')->onDelete('set null');
            $table->text('indicador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas_cotejo');
    }
};
