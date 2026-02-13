<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Conceptos evaluativos (dimensiones del desarrollo)
        Schema::create('conceptos_evaluativos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Evaluaciones por estudiante
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('concepto_evaluativo_id')->constrained('conceptos_evaluativos')->onDelete('cascade');
            $table->string('periodo', 20); // P1, P2, P3, P4
            $table->year('anio')->default(date('Y'));
            $table->string('valoracion', 30)->default('en_proceso');
            // superior, alto, basico, bajo, en_proceso
            $table->text('observacion')->nullable();
            $table->foreignId('evaluado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['estudiante_id', 'concepto_evaluativo_id', 'periodo', 'anio'], 'eval_unica');
            $table->index(['grupo_id', 'periodo', 'anio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
        Schema::dropIfExists('conceptos_evaluativos');
    }
};
