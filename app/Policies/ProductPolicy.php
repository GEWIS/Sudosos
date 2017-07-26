<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        return $user->hasPermission('view-products', $product->owner->id);
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\Models\User  $user
     * @param  Integer $owner_id
     * @return mixed
     */
    public function create(User $user, $owner_id)
    {
        return $user->hasPermission('create-products', $owner_id);
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return $user->hasPermission('update-products', $product->owner->id);
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        return $user->hasPermission('delete-products', $product->owner->id);

    }
}
