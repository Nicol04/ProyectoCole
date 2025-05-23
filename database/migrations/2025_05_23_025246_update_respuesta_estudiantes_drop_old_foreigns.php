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
            $table->dropForeign(['pregunta_id']);
            $table->dropForeign(['respuesta_id']);

            $table->dropColumn(['pregunta_id', 'respuesta_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuesta_estudiantes', function (Blueprint $table) {
            $table->unsignedBigInteger('pregunta_id')->nullable();
            $table->unsignedBigInteger('respuesta_id')->nullable();

            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
            $table->foreign('respuesta_id')->references('id')->on('respuestas')->onDelete('cascade');
        });
    }
};
