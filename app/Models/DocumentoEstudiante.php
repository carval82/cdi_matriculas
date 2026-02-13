<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoEstudiante extends Model
{
    protected $table = 'documentos_estudiante';

    protected $fillable = [
        'estudiante_id', 'tipo', 'nombre', 'archivo', 'observaciones', 'subido_por',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function subidoPor()
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    public static function tipos(): array
    {
        return [
            'registro_civil' => 'Registro Civil',
            'tarjeta_identidad' => 'Tarjeta de Identidad',
            'sisben' => 'Certificado SISBEN',
            'eps' => 'Certificado EPS',
            'condicion_medica' => 'Certificado Condición Médica',
            'vacunacion' => 'Carné de Vacunación',
            'foto' => 'Fotografía',
            'otro' => 'Otro Documento',
        ];
    }
}
