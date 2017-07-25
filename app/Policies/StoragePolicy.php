<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Storage;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoragePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Storage  $storage
     * @return mixed
     */
    public function view(User $user, Storage $storage)
    {
       return $user->hasPermission('view-storages', $storage->owner->id);
    }

    /**
     * Determine whether the user can create storages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $owner_id)
    {
        return $user->hasPermission('create-storages', $owner_id);

    }

    /**
     * Determine whether the user can update the storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Storage  $storage
     * @return mixed
     */
    public function update(User $user, Storage $storage)
    {
        return $user->hasPermission('update-storages', $storage->owner->id);
    }

    /**
     * Determine whether the user can delete the storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Storage  $storage
     * @return mixed
     */
    public function delete(User $user, storage $storage)
    {
        return $user->hasPermission('delete-storages', $storage->owner->id);

    }
}
