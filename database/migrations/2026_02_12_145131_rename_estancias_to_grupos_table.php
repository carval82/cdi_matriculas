<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('estancias', 'grupos');

        Schema::table('estudiantes', function (Blueprint $table) {
            $table->renameColumn('estancia_id', 'grupo_id');
        });

        Schema::table('matriculas', function (Blueprint $table) {
            $table->renameColumn('estancia_id', 'grupo_id');
        });
    }

    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->renameColumn('grupo_id', 'estancia_id');
        });

        Schema::table('estudiantes', function (Blueprint $table) {
            $table->renameColumn('grupo_id', 'estancia_id');
        });

        Schema::rename('grupos', 'estancias');
    }
};
