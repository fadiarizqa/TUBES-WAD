<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LostItem;

class LostItemPolicy
{
    public function update(User $user, LostItem $lostItem): bool
    {
        return $user->id === $lostItem->user_id;
    }

    public function delete(User $user, LostItem $lostItem): bool
    {
        return $user->id === $lostItem->user_id;
    }
}
