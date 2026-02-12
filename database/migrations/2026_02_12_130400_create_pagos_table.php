<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('recibo', 30)->nullable()->unique();
            $table->foreignId('matricula_id')->constrained('matriculas')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->string('concepto', 50);                      // matricula, pension, material, otro
            $table->string('mes', 20)->nullable();               // enero, febrero... (para pensiones)
            $table->decimal('valor', 12, 2);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('recargo', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('metodo_pago', 30)->default('efectivo');
            $table->string('referencia_pago', 100)->nullable();
            $table->date('fecha_pago');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('estado', 20)->default('pagado');     // pagado, pendiente, anulado, vencido
            $table->text('observaciones')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['matricula_id', 'concepto']);
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
