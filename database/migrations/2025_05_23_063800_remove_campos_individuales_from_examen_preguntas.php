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
        Schema::table('examen_preguntas', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_pregunta',
                'pregunta',
                'opcion_a',
                'opcion_b',
                'opcion_c',
                'respuesta_correcta',
            ]);
            $table->json('examen_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examen_preguntas', function (Blueprint $table) {
            $table->string('tipo_pregunta')->nullable();
            $table->text('pregunta')->nullable();
            $table->string('opcion_a')->nullable();
            $table->string('opcion_b')->nullable();
            $table->string('opcion_c')->nullable();
            $table->string('respuesta_correcta')->nullable();
            $table->dropColumn('examen_json');
        });
    }
};
