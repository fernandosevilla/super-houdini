<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Zona;
use App\Models\Credencial;
use App\Policies\CredencialPolicy;
use App\Policies\ZonaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El array $policies asocia modelos con sus Policies.
     */
    protected $policies = [
        Zona::class => ZonaPolicy::class,
        Credencial::class => CredencialPolicy::class,
    ];

    /**
     * Registra las policies y define Gates adicionales si necesitas.
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
