<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    protected $table = 'establecimiento';

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'celular',
        'email',
        'ciudad',
        'departamento',
        'representante_legal',
        'logo',
        'descripcion',
        'lema',
        'resolucion',
    ];

    public static function datos()
    {
        return static::first();
    }

    public function logoUrl()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return null;
    }
}
