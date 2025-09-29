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
        Schema::table('sesions', function (Blueprint $table) {
            $table->string('tema')->nullable()->after('titulo');
            $table->integer('tiempo_estimado')->nullable()->after('tema');

            // Para renombrar columna (requiere doctrine/dbal)
            $table->renameColumn('objetivo', 'proposito_sesion');

            // Relación con users
            $table->foreignId('docente_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Eliminar columna actividades
            $table->dropColumn('actividades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesions', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropColumn(['tema', 'tiempo_estimado', 'docente_id']);

            $table->renameColumn('proposito_sesion', 'objetivo');

            $table->text('actividades')->nullable();
        });
    }
};
