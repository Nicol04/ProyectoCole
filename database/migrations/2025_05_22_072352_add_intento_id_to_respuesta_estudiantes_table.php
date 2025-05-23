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
            $table->unsignedBigInteger('intento_id')->after('id');
            $table->foreign('intento_id')->references('id')->on('intentos_evaluacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuesta_estudiantes', function (Blueprint $table) {
            $table->dropForeign(['intento_id']);
            $table->dropColumn('intento_id');
        });
    }
};
