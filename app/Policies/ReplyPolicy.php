<?php

namespace App\Policies;

use App\Forum\Replies\Reply;
use App\Forum\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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
     * User can only replies that they created or have the ability to edit replies
     * @param  User   $user
     * @param  Post   $post
     * @return boolean
     */
    public function edit(User $user, Reply $reply)
    {
        return $user->owns($reply) || $user->can('edit-replies');
    }

    /**
     * User can only delete to replies that they own or they have the ability to delete replies
     * @param  User   $user
     * @param  Reply  $reply
     * @return boolean
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->owns($reply) || $user->can('delete-replies');
    }
}
