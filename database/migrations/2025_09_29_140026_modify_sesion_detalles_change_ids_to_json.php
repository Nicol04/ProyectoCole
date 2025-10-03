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
        Schema::table('sesion_detalles', function (Blueprint $table) {
            $table->dropForeign(['competencia_id']);
            $table->dropForeign(['capacidad_id']); 
            $table->dropForeign(['desempeno_id']);
            $table->dropColumn(['competencia_id', 'capacidad_id', 'desempeno_id']);
            
            // Agregar columnas JSON
            $table->json('competencias')->nullable();
            $table->json('capacidades')->nullable();
            $table->json('desempenos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_detalles', function (Blueprint $table) {
            $table->dropColumn(['competencias', 'capacidades', 'desempenos']);
            $table->unsignedBigInteger('competencia_id')->nullable();
            $table->unsignedBigInteger('capacidad_id')->nullable();
            $table->unsignedBigInteger('desempeno_id')->nullable();
        });
    }
};
