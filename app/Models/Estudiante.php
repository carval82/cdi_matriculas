<?php

namespace App\Models;

use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'tipo_documento', 'documento', 'nombres', 'apellidos',
        'fecha_nacimiento', 'lugar_nacimiento', 'nacionalidad', 'pais_origen',
        'genero', 'rh', 'eps', 'tipo_eps',
        'tiene_sisben', 'grupo_sisben',
        'tiene_discapacidad', 'tipo_discapacidad', 'diagnostico_medico',
        'tipo_poblacion', 'estrato', 'condicion_especial_salud',
        'foto', 'alergias', 'condiciones_medicas', 'medicamentos',
        'contacto_emergencia', 'telefono_emergencia',
        'acudiente_id', 'acudiente_secundario_id', 'grupo_id',
        'estado', 'fecha_ingreso', 'fecha_retiro', 'observaciones',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'fecha_retiro' => 'date',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function getEdadAttribute(): string
    {
        $nacimiento = $this->fecha_nacimiento;
        if (!$nacimiento) return '';

        $anios = $nacimiento->age;
        $meses = $nacimiento->diffInMonths(now()) % 12;

        if ($anios > 0) {
            return "{$anios} año" . ($anios > 1 ? 's' : '') . " {$meses} mes" . ($meses != 1 ? 'es' : '');
        }
        return "{$meses} mes" . ($meses != 1 ? 'es' : '');
    }

    public function getEdadMesesAttribute(): int
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->diffInMonths(now()) : 0;
    }

    public function acudiente()
    {
        return $this->belongsTo(Acudiente::class);
    }

    public function acudienteSecundario()
    {
        return $this->belongsTo(Acudiente::class, 'acudiente_secundario_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function matriculaActiva()
    {
        return $this->hasOne(Matricula::class)->where('estado', 'activa')->latest();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoEstudiante::class);
    }
}
