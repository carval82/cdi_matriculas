<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Nacionalidad y migración
            $table->string('nacionalidad', 50)->default('Colombiana')->after('lugar_nacimiento');
            $table->string('pais_origen', 50)->nullable()->after('nacionalidad');

            // Tipo de afiliación EPS
            $table->string('tipo_eps', 30)->nullable()->after('eps');
            // contributivo, subsidiado, beneficiario, no_afiliado, regimen_especial

            // SISBEN
            $table->boolean('tiene_sisben')->default(false)->after('tipo_eps');
            $table->string('grupo_sisben', 10)->nullable()->after('tiene_sisben');
            // A1-A5, B1-B7, C1-C18, D1-D21

            // Discapacidad / condición especial
            $table->boolean('tiene_discapacidad')->default(false)->after('grupo_sisben');
            $table->string('tipo_discapacidad', 100)->nullable()->after('tiene_discapacidad');
            // fisica, cognitiva, sensorial_visual, sensorial_auditiva, psicosocial, multiple, ninguna

            // Diagnóstico médico específico
            $table->text('diagnostico_medico')->nullable()->after('tipo_discapacidad');

            // Tipo de población
            $table->string('tipo_poblacion', 80)->nullable()->after('diagnostico_medico');
            // ninguna, victima_conflicto, desplazado, indigena, afrocolombiano,
            // raizal, palenquero, rom_gitano, migrante, reincorporado, cabeza_de_hogar

            // Estrato socioeconómico
            $table->tinyInteger('estrato')->nullable()->after('tipo_poblacion');
            // 1-6

            // Condición especial de salud
            $table->text('condicion_especial_salud')->nullable()->after('estrato');
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn([
                'nacionalidad', 'pais_origen',
                'tipo_eps', 'tiene_sisben', 'grupo_sisben',
                'tiene_discapacidad', 'tipo_discapacidad',
                'diagnostico_medico', 'tipo_poblacion',
                'estrato', 'condicion_especial_salud',
            ]);
        });
    }
};
