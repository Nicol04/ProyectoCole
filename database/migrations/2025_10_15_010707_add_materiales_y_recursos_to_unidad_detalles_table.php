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
        Schema::table('unidad_detalles', function (Blueprint $table) {
            $table->text('materiales_basicos')
                ->nullable()
                ->after('enfoques')
                ->comment('Materiales básicos a utilizar en la unidad');

            $table->text('recursos')
                ->nullable()
                ->after('materiales_basicos')
                ->comment('Recursos a utilizar en la unidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidad_detalles', function (Blueprint $table) {
            $table->dropColumn(['materiales_basicos', 'recursos']);
        });
    }
};
