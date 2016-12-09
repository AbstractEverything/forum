<?php

namespace App\Policies;

use App\Forum\Forums\Forum;
use App\Forum\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
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
     * Users can only create posts in open forums and they have the the ability to create posts
     * @param  User   $user 
     * @param  Forum  $forum
     * @return boolean
     */
    public function create(User $user, Forum $forum)
    {
        return $user->can('create-posts') && ! $forum->closed || $user->can('post-in-closed-forums');
    }

    /**
     * Check that the user can perform edit or delete operations on forums
     * @param  User   $user
     * @param  User   $banned
     * @return boolean
     */
    public function modify(User $user, Forum $forum)
    {
        return $user->can('edit-forums') || $user->can('delete-forums');
    }
}
