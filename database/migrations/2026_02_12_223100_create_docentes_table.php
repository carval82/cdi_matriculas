<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('tipo_documento', 10)->default('CC');
            $table->string('documento', 30)->unique();
            $table->string('celular', 30)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('titulo', 150)->nullable();
            $table->string('foto', 255)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Pivot docente-grupo
        Schema::create('docente_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->string('rol', 50)->default('titular'); // titular, auxiliar
            $table->year('anio')->default(date('Y'));
            $table->timestamps();

            $table->unique(['docente_id', 'grupo_id', 'anio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_grupo');
        Schema::dropIfExists('docentes');
    }
};
