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
            // Eliminar la columna anterior si existe
            if (Schema::hasColumn('respuesta_estudiantes', 'respuesta_abierta')) {
                $table->dropColumn('respuesta_abierta');
            }

            // Agregar nueva columna JSON
            $table->json('respuesta_json')->nullable()->after('fecha_respuesta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuesta_estudiantes', function (Blueprint $table) {
            // Restaurar columna anterior (texto abierto)
            $table->text('respuesta_abierta')->nullable()->after('fecha_respuesta');

            // Eliminar columna nueva
            $table->dropColumn('respuesta_json');
        });
    }
};
