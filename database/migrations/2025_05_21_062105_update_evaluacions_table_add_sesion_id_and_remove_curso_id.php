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
        Schema::table('evaluacions', function (Blueprint $table) {
            // Elimina la columna curso_id
            $table->dropForeign(['curso_id']); // si es clave foránea
            $table->dropColumn('curso_id');

            // Agrega sesion_id como clave foránea
            $table->unsignedBigInteger('sesion_id')->after('id');
            $table->foreign('sesion_id')->references('id')->on('sesions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluacions', function (Blueprint $table) {
            // Restaurar curso_id en rollback
            $table->unsignedBigInteger('curso_id')->nullable();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');

            // Eliminar sesion_id
            $table->dropForeign(['sesion_id']);
            $table->dropColumn('sesion_id');
        });
    }
};
