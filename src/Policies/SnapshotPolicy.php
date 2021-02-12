<?php

namespace Tipoff\Reviews\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;
use Tipoff\Reviews\Models\Snapshot;

class SnapshotPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view snapshots') ? true : false;
    }

    public function view(UserInterface $user, Snapshot $snapshot): bool
    {
        return $user->hasPermissionTo('view snapshots') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return false;
    }

    public function update(UserInterface $user, Snapshot $snapshot): bool
    {
        return false;
    }

    public function delete(UserInterface $user, Snapshot $snapshot): bool
    {
        return false;
    }

    public function restore(UserInterface $user, Snapshot $snapshot): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Snapshot $snapshot): bool
    {
        return false;
    }
}
