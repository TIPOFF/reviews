<?php

namespace Tipoff\Reviews\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Reviews\Models\Insight;

class InsightPolicy
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
        return $user->hasPermissionTo('view insights') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Insight  $insight
     * @return mixed
     */
    public function view(User $user, Insight $insight)
    {
        return $user->hasPermissionTo('view insights') ? true : false;
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
     * @param  \App\Insight  $insight
     * @return mixed
     */
    public function update(User $user, Insight $insight)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Insight  $insight
     * @return mixed
     */
    public function delete(User $user, Insight $insight)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Insight  $insight
     * @return mixed
     */
    public function restore(User $user, Insight $insight)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Insight  $insight
     * @return mixed
     */
    public function forceDelete(User $user, Insight $insight)
    {
        return false;
    }
}