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
            $table->string('enfoque_transversal')->nullable()->after('desempenos');
            $table->text('competencia_transversal')->nullable()->after('enfoque_transversal');
            $table->text('capacidad_transversal')->nullable()->after('competencia_transversal');
            $table->text('desempeno_transversal')->nullable()->after('capacidad_transversal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_detalles', function (Blueprint $table) {
            $table->dropColumn([
                'enfoque_transversal',
                'competencia_transversal',
                'capacidad_transversal',
                'desempeno_transversal',
            ]);
        });
    }
};
