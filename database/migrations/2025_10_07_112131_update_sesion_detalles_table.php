<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sesion_detalles', function (Blueprint $table) {
            if (Schema::hasColumn('sesion_detalles', 'criterio_id')) {
                try {
                    $table->dropForeign(['criterio_id']);
                } catch (\Exception $e) {
                    DB::statement('ALTER TABLE sesion_detalles DROP FOREIGN KEY sesion_detalles_criterio_id_foreign');
                }
                $table->dropColumn('criterio_id');
            }
            $table->text('criterio')->nullable()->after('sesion_id');
            $table->text('desempeno_transversal')->nullable()->after('capacidad_transversal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesion_detalles', function (Blueprint $table) {
            $table->dropColumn(['criterio', 'desempeno_transversal']);
            $table->unsignedBigInteger('criterio_id')->nullable();
            $table->foreign('criterio_id')
                ->references('id')
                ->on('criterios_evaluacion')
                ->onDelete('cascade');
        });
    }
};
