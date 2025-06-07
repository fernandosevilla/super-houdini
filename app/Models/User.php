<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones

    /**
     * Relación con Zona
     */
    public function zonas() {
        return $this->belongsToMany(Zona::class, 'zona_usuario')
                    ->using(ZonaUsuario::class)
                    ->withPivot('estado', 'fecha_solicitud', 'fecha_respuesta')
                    ->withTimestamps();
    }

    public function zonas_creadas() {
        return $this->hasMany(Zona::class, 'user_id');
    }

    public function credenciales() {
        return $this->hasMany(Credencial::class, 'creado_por');
    }

    public function rotaciones() {
        return $this->hasMany(Rotacion::class);
    }
}
