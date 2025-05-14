<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    public function update(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function register(User $user, Event $event)
    {
        return $user->isVolunteer() && $event->status === 'active';
    }
}
