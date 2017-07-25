<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;

use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        return $user->hasPermission('view-transactions', $transaction->owner->id);
    }

    /**
     * Determine whether the user can create transactions.
     *
     * @param  \App\Models\User  $user
     * @param  Integer $owner_id
     * @return mixed
     */
    public function create(User $user, $owner_id)
    {
        return $user->hasPermission('create-transactions', $owner_id);

    }

    /**
     * Determine whether the user can update the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        return $user->hasPermission('update-transactions', $transaction->owner->id);
    }

    /**
     * Determine whether the user can delete the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        return $user->hasPermission('delete-transactions', $transaction->owner->id);

    }
}
