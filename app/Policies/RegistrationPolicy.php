<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any registrations.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the registration.
     */
    public function view(User $user, Registration $registration): bool
    {
        return $user->id === $registration->user_id;
    }

    /**
     * Determine whether the user can create registrations.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the registration.
     */
    public function update(User $user, Registration $registration): bool
    {
        return $user->id === $registration->user_id;
    }

    /**
     * Determine whether the user can delete the registration.
     */
    public function delete(User $user, Registration $registration): bool
    {
        return $user->id === $registration->user_id;
    }
}