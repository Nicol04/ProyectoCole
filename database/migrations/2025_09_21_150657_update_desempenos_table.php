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
        Schema::table('desempenos', function (Blueprint $table) {
            // Eliminar criterio_id
            if (Schema::hasColumn('desempenos', 'criterio_id')) {
                $table->dropForeign(['criterio_id']);
                $table->dropColumn('criterio_id');
            }

            // Asegurar que tiene capacidad_id
            if (!Schema::hasColumn('desempenos', 'capacidad_id')) {
                $table->foreignId('capacidad_id')->after('id')->constrained('capacidades')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desempenos', function (Blueprint $table) {
            // Revertir cambios
            $table->foreignId('criterio_id')->nullable()->constrained('criterios_evaluacion')->onDelete('cascade');
            $table->dropForeign(['capacidad_id']);
            $table->dropColumn('capacidad_id');
        });
    }
};
