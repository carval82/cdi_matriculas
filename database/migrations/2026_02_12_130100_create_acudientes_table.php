<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acudientes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 10)->default('CC');
            $table->string('documento', 30)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('parentesco', 50)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('celular', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('barrio', 100)->nullable();
            $table->string('ocupacion', 100)->nullable();
            $table->string('empresa_trabajo', 150)->nullable();
            $table->string('telefono_trabajo', 30)->nullable();
            $table->string('eps', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acudientes');
    }
};
