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
        Schema::table('archivos', function (Blueprint $table) {
            // Primero eliminar claves foráneas (foreign keys)
            if (Schema::hasColumn('archivos', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
            if (Schema::hasColumn('archivos', 'sesion_id')) {
                $table->dropForeign(['sesion_id']);
            }

            // Luego eliminar columnas
            if (Schema::hasColumn('archivos', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('archivos', 'sesion_id')) {
                $table->dropColumn('sesion_id');
            }

            // Ejemplo para otra columna sin foreign key
            if (Schema::hasColumn('archivos', 'nombre')) {
                $table->dropColumn('nombre');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sesion_id')->nullable();
            $table->string('nombre')->nullable();

            // Volver a crear claves foráneas si aplica
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sesion_id')->references('id')->on('sesions')->onDelete('cascade');
        });
    }
};
