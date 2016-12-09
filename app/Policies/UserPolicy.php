<?php

namespace App\Policies;

use App\Forum\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check that the user can ban users and is not trying to ban a super admin
     * @param  User   $user
     * @param  User   $banned
     * @return boolean
     */
    public function ban(User $user, User $banned)
    {
        return $user->can('ban-users') && ! $banned->is('super');
    }
}
