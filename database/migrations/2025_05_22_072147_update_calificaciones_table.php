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
        Schema::table('calificaciones', function (Blueprint $table) {
            if (Schema::hasColumn('calificaciones', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('calificaciones', 'evaluacion_id')) {
                $table->dropForeign(['evaluacion_id']);
                $table->dropColumn('evaluacion_id');
            }

            // Agregar nueva relación intento_id
            $table->unsignedBigInteger('intento_id')->after('id');
            $table->foreign('intento_id')->references('id')->on('intentos_evaluacion')->onDelete('cascade');

            // Renombrar columna nota a puntaje_total
            if (Schema::hasColumn('calificaciones', 'nota')) {
                $table->renameColumn('nota', 'puntaje_total');
            }

            // Nuevas columnas
            $table->integer('puntaje_maximo')->nullable();
            $table->float('porcentaje')->nullable();
            $table->string('estado')->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            // Eliminar nuevas columnas
            $table->dropForeign(['intento_id']);
            $table->dropColumn('intento_id');

            if (Schema::hasColumn('calificaciones', 'puntaje_total')) {
                $table->renameColumn('puntaje_total', 'nota');
            }

            $table->dropColumn('puntaje_maximo');
            $table->dropColumn('porcentaje');
            $table->dropColumn('estado');

            // Restaurar columnas eliminadas
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('evaluacion_id')->nullable();
        });
    }
};
