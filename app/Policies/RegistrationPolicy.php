<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegistrationPolicy
{
    public function cancel(User $user, Registration $registration)
    {
        return $user->id === $registration->user_id;
    }
}
