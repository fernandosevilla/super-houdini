<?php

namespace App\Policies;

use App\Models\Credencial;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CredencialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Credencial $cred)
    {
        // si yo soy el que creó la credencial
        if ($cred->creado_por === $user->id) {
            return true;
        }

        // si yo soy el creador de la zona que contiene esta credencial
        if ($cred->zona->user_id === $user->id) {
            return true;
        }

        // si estoy compartido (estado='aceptado') en esa zona
        return $cred->zona->usuarios()
            ->where('users.id', $user->id)
            ->wherePivot('estado', 'aceptado')
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Credencial $cred)
    {
        return $user->id === $cred->creado_por || $user->id === $cred->zona->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Credencial $cred)
    {
        return $user->id === $cred->creado_por || $user->id === $cred->zona->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Credencial $credencial): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Credencial $credencial): bool
    {
        return false;
    }
}
