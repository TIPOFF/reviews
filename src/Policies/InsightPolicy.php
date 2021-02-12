<?php

namespace Tipoff\Reviews\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Reviews\Models\Insight;

class InsightPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view insights') ? true : false;
    }

    public function view(UserInterface $user, Insight $insight): bool
    {
        return $user->hasPermissionTo('view insights') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, Insight $insight): bool
    {
        return false;
    }

    public function delete(UserInterface $user, Insight $insight): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Insight $insight): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Insight $insight): bool
    {
        return false;
    }
}
