<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Zona;
use Illuminate\Auth\Access\Response;

class ZonaPolicy
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
    public function view(User $user, Zona $zona)
    {
        // si soy el creador de la zona, devuelvo true
        if ($zona->user_id === $user->id) {
            return true;
        }

        // si estoy en el pivote con estado 'aceptado', devuelvo true
        return $zona->usuarios()
            ->where('users.id', $user->id)
            ->wherePivot('estado', 'aceptado')
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Zona $zona): bool
    {
        return $zona->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Zona $zona): bool
    {
        return $zona->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Zona $zona): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Zona $zona): bool
    {
        return false;
    }
}
