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
            $table->foreignId('estandar_id')
                ->nullable()
                ->after('id') // lo agrega después del id
                ->constrained('estandares')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desempenos', function (Blueprint $table) {
            $table->dropForeign(['estandar_id']);
            $table->dropColumn('estandar_id');
        });
    }
};
