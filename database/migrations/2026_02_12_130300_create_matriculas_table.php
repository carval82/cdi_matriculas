<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->nullable()->unique(); // MAT-2026-001
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('estancia_id')->constrained('estancias')->onDelete('restrict');
            $table->foreignId('acudiente_id')->constrained('acudientes')->onDelete('restrict');
            $table->integer('anio');                             // 2026
            $table->string('periodo', 20)->default('anual');     // anual, semestre1, semestre2
            $table->date('fecha_matricula');
            $table->decimal('valor_matricula', 12, 2)->default(0);
            $table->decimal('valor_pension', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->string('tipo_descuento', 50)->nullable();    // hermano, becado, empleado, etc.
            $table->string('estado', 20)->default('activa');     // activa, cancelada, finalizada, suspendida
            $table->string('jornada', 30)->default('completa');
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['anio', 'estado']);
            $table->index('estudiante_id');
            $table->index('estancia_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
