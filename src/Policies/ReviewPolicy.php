<?php

namespace Tipoff\Reviews\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Locations\Traits\HasLocationPermissions;
use Tipoff\Reviews\Models\Review;
use Tipoff\Support\Contracts\Models\UserInterface;

class ReviewPolicy
{
    use HandlesAuthorization;
    use HasLocationPermissions;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view reviews') ? true : false;
    }

    public function view(UserInterface $user, Review $review): bool
    {
        return $this->hasLocationPermission($user, 'view reviews', $review->location_id);
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, Review $review): bool
    {
        return $this->hasLocationPermission($user, 'update reviews', $review->location_id);
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
