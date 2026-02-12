<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'recibo', 'matricula_id', 'estudiante_id', 'concepto',
        'mes', 'valor', 'descuento', 'recargo', 'total',
        'metodo_pago', 'referencia_pago', 'fecha_pago',
        'fecha_vencimiento', 'estado', 'observaciones', 'created_by',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_vencimiento' => 'date',
        'valor' => 'decimal:2',
        'descuento' => 'decimal:2',
        'recargo' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generarRecibo(): string
    {
        $ultimo = static::whereNotNull('recibo')->max('id') ?? 0;
        return sprintf('REC-%06d', $ultimo + 1);
    }
}
