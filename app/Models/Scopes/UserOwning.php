<?php

namespace App\Models\Scopes;

use App\Models\User;

trait UserOwning
{
    public function scopeUserOwned($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeUserOwnedById($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function isOwnedByUser(User $user)
    {
        return $this->user_id === $user->id;
    }
}
