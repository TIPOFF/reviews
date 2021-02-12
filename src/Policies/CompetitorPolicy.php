<?php

namespace Tipoff\Reviews\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Reviews\Models\Competitor;

class CompetitorPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view competitors') ? true : false;
    }

    public function view(UserInterface $user, Competitor $competitor): bool
    {
        return $user->hasPermissionTo('view competitors') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create competitors') ? true : false;
    }

    public function update(UserInterface $user, Competitor $competitor): bool
    {
        return $user->hasPermissionTo('update competitors') ? true : false;
    }

    public function delete(UserInterface $user, Competitor $competitor): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Competitor $competitor): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Competitor $competitor)
    {
        return false;
    }
}
