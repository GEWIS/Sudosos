<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PointOfSale;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointOfSalePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the point of sale.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PointOfSale  $pos
     * @return mixed
     */
    public function view(User $user, PointOfSale $pos)
    {
       return $user->hasPermission('view-pointsofsale', $pos->owner->id);
    }

    /**
     * Determine whether the user can create a point of sale.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $owner_id)
    {
        return $user->hasPermission('create-pointsofsale', $owner_id);

    }

    /**
     * Determine whether the user can update the point of sale.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PointOfSale  $pos
     * @return mixed
     */
    public function update(User $user, PointOfSale $pos)
    {
        return $user->hasPermission('update-pointsofsale', $pos->owner->id);
    }

    /**
     * Determine whether the user can delete the point of sale.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PointOfSale  $pos
     * @return mixed
     */
    public function delete(User $user, PointOfSale $pos)
    {
        return $user->hasPermission('delete-pointsofsale', $pos->owner->id);

    }
}
