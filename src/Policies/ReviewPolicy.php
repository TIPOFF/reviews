<?php

namespace Tipoff\Reviews\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Reviews\Models\Review;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view reviews') ? true : false;
    }

    public function view(UserInterface $user, Review $review): bool
    {
        return $user->hasPermissionTo('view reviews') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, Review $review): bool
    {
        return $user->hasPermissionTo('update reviews') ? true : false;
    }

    public function delete(UserInterface $user, Review $review): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Review $review): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Review $review): bool
    {
        return false;
    }
}
