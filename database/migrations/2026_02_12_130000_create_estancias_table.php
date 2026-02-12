<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estancias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);              // Párvulos, Jardín, Pre-Jardín, Preescolar
            $table->string('codigo', 20)->nullable();    // PAR, JAR, PRE, etc.
            $table->integer('edad_minima')->nullable();  // Edad mínima en meses
            $table->integer('edad_maxima')->nullable();  // Edad máxima en meses
            $table->integer('capacidad')->default(25);
            $table->string('jornada', 30)->default('completa'); // completa, mañana, tarde
            $table->decimal('valor_matricula', 12, 2)->default(0);
            $table->decimal('valor_pension', 12, 2)->default(0);
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estancias');
    }
};
