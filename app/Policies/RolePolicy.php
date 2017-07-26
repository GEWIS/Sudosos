<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RBAC\Role;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RBAC\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->hasPermission('view-roles', $role->owner->id);
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @param  Integer $owner_id
     * @return mixed
     */
    public function create(User $user, $owner_id)
    {
        return $user->hasPermission('create-roles', $owner_id);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RBAC\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasPermission('update-roles', $role->owner->id);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RBAC\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('delete-roles', $role->owner->id);

    }
}
