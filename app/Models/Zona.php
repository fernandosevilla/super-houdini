<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    /** @use HasFactory<\Database\Factories\ZonaFactory> */
    use HasFactory;

    protected $table = 'zonas';

    protected $fillable = [
        'nombre',
        'requiere_verificacion',
        'user_id',
    ];

    protected $casts = [
        'requiere_verificacion' => 'boolean',
    ];

    // Relaciones
    public function creador() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarios() {
        return $this->belongsToMany(User::class, 'zona_usuario')
                    ->withPivot('estado', 'fecha_solicitud', 'fecha_respuesta')
                    ->withTimestamps();
    }

    public function credenciales() {
        return $this->hasMany(Credencial::class);
    }
}
