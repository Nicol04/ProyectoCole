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
        Schema::table('respuesta_estudiantes', function (Blueprint $table) {
            $table->unsignedBigInteger('examen_pregunta_id')->nullable()->after('intento_id');
            $table->foreign('examen_pregunta_id')->references('id')->on('examen_preguntas')->onDelete('cascade');

            $table->text('respuesta_abierta')->nullable()->change(); // si no lo habías hecho aún
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuesta_estudiantes', function (Blueprint $table) {
            $table->dropForeign(['examen_pregunta_id']);
            $table->dropColumn('examen_pregunta_id');
        });
    }
};
