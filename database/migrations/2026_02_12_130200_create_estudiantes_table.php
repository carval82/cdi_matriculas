<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->nullable()->unique();
            $table->string('tipo_documento', 10)->default('RC'); // RC, TI, NUIP
            $table->string('documento', 30)->nullable();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento', 100)->nullable();
            $table->string('genero', 15)->default('masculino'); // masculino, femenino
            $table->string('rh', 10)->nullable();               // O+, O-, A+, A-, B+, B-, AB+, AB-
            $table->string('eps', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('alergias')->nullable();
            $table->text('condiciones_medicas')->nullable();
            $table->text('medicamentos')->nullable();
            $table->string('contacto_emergencia', 100)->nullable();
            $table->string('telefono_emergencia', 30)->nullable();
            $table->foreignId('acudiente_id')->constrained('acudientes')->onDelete('cascade');
            $table->foreignId('acudiente_secundario_id')->nullable()->constrained('acudientes')->onDelete('set null');
            $table->foreignId('estancia_id')->nullable()->constrained('estancias')->onDelete('set null');
            $table->string('estado', 20)->default('activo'); // activo, retirado, graduado, suspendido
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('estado');
            $table->index('estancia_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
