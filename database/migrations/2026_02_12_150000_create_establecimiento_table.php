<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('establecimiento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('nit', 50)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('celular', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('departamento', 100)->nullable();
            $table->string('representante_legal', 200)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('lema', 255)->nullable();
            $table->string('resolucion', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establecimiento');
    }
};
