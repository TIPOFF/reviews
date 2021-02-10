<?php

namespace Tipoff\Reviews\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Reviews\Models\Snapshot;

class SnapshotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view snapshots') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Snapshot  $snapshot
     * @return mixed
     */
    public function view(User $user, Snapshot $snapshot)
    {
        return $user->hasPermissionTo('view snapshots') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Snapshot  $snapshot
     * @return mixed
     */
    public function update(User $user, Snapshot $snapshot)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Snapshot  $snapshot
     * @return mixed
     */
    public function delete(User $user, Snapshot $snapshot)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Snapshot  $snapshot
     * @return mixed
     */
    public function restore(User $user, Snapshot $snapshot)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Snapshot  $snapshot
     * @return mixed
     */
    public function forceDelete(User $user, Snapshot $snapshot)
    {
        return false;
    }
}
