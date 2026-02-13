<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoEvaluativo extends Model
{
    protected $table = 'conceptos_evaluativos';

    protected $fillable = [
        'nombre', 'descripcion', 'orden', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
}
