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
        Schema::table('sesion_momentos', function (Blueprint $table) {
            if (Schema::hasColumn('sesion_momentos', 'momento')) {
                $table->dropColumn('momento');
            }
            if (Schema::hasColumn('sesion_momentos', 'estrategia')) {
                $table->dropColumn('estrategia');
            }

            // Agregamos el nuevo campo JSON
            $table->json('contenido')->nullable()->after('descripcion_actividad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_momentos', function (Blueprint $table) {
            $table->string('momento')->nullable();
            $table->text('estrategia')->nullable();

            // Eliminamos el campo JSON si existe
            if (Schema::hasColumn('sesion_momentos', 'contenido')) {
                $table->dropColumn('contenido');
            }
        });
    }
};
