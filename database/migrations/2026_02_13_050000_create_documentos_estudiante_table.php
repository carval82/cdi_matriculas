<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->string('tipo', 80); // registro_civil, sisben, condicion_medica, eps, otro
            $table->string('nombre', 200);
            $table->string('archivo'); // ruta del archivo
            $table->text('observaciones')->nullable();
            $table->foreignId('subido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('matriculas', function (Blueprint $table) {
            $table->string('pdf_firmado')->nullable()->after('observaciones');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_estudiante');

        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropColumn('pdf_firmado');
        });
    }
};
