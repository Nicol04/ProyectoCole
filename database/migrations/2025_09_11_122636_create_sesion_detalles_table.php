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
        Schema::create('sesion_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesions')->onDelete('cascade');
            $table->foreignId('competencia_id')->nullable()->constrained('competencias')->onDelete('set null');
            $table->foreignId('capacidad_id')->nullable()->constrained('capacidades')->onDelete('set null');
            $table->foreignId('criterio_id')->nullable()->constrained('criterios_evaluacion')->onDelete('set null');
            $table->foreignId('desempeno_id')->nullable()->constrained('desempenos')->onDelete('set null');
            $table->text('evidencia')->nullable();
            $table->text('instrumento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_detalles');
    }
};
