<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'estudiante_id', 'grupo_id', 'concepto_evaluativo_id',
        'periodo', 'anio', 'valoracion', 'observacion', 'evaluado_por',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function concepto()
    {
        return $this->belongsTo(ConceptoEvaluativo::class, 'concepto_evaluativo_id');
    }

    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluado_por');
    }

    public static function valoraciones(): array
    {
        return [
            'superior' => 'Superior',
            'alto' => 'Alto',
            'basico' => 'Básico',
            'bajo' => 'Bajo',
            'en_proceso' => 'En Proceso',
        ];
    }

    public static function periodos(): array
    {
        return [
            'P1' => 'Periodo 1',
            'P2' => 'Periodo 2',
            'P3' => 'Periodo 3',
            'P4' => 'Periodo 4',
        ];
    }
}
