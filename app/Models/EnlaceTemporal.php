<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceTemporal extends Model
{
    /** @use HasFactory<\Database\Factories\EnlaceTemporalFactory> */
    use HasFactory;

    protected $table = 'enlaces_temporales';

    protected $fillable = [
        'credencial_id',
        'hash_seguro',
        'expira_en',
        'usado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado' => 'boolean',
    ];

    // Relaciones
    public function credencial() {
        return $this->belongsTo(Credencial::class);
    }
}
