<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credencial extends Model
{
    /** @use HasFactory<\Database\Factories\CredencialFactory> */
    use HasFactory;

    protected $table = 'credenciales';

    protected $fillable = [
        'creado_por',
        'zona_id',
        'nombre_sitio',
        'nombre_usuario',
        'contrasenia',
        'url',
        'notas',
        'ultima_consulta',
        'rotacion_cada_dias',
        'fecha_ultima_rotacion',
    ];

    protected $casts = [
        'ultima_consulta' => 'datetime',
        'rotacion_cada_dias' => 'integer',
        'fecha_ultima_rotacion' => 'datetime',
    ];

    // Relaciones
    public function zona() {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function creador() {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function rotaciones() {
        return $this->hasMany(Rotacion::class);
    }

    public function enlaces_temporales() {
        return $this->hasMany(EnlaceTemporal::class);
    }
}
