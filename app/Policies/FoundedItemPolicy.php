<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FoundedItem;

class FoundedItemPolicy
{
    public function update(User $user, FoundedItem $foundedItem): bool
    {
        return $user->id === $foundedItem->user_id;
    }

    public function delete(User $user, FoundedItem $foundedItem): bool
    {
        return $user->id === $foundedItem->user_id;
    }
}
