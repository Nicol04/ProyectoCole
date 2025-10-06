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
            $table->foreignId('capacidad_transversal_id')
                ->nullable()
                ->constrained('capacidades_transversales')
                ->nullOnDelete()
                ->after('capacidad_id');
        });

        // Aseguramos que capacidad_id también pueda ser nulo
        Schema::table('desempenos', function (Blueprint $table) {
            $table->foreignId('capacidad_id')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desempenos', function (Blueprint $table) {
            $table->dropForeign(['capacidad_transversal_id']);
            $table->dropColumn('capacidad_transversal_id');
        });
    }
};
