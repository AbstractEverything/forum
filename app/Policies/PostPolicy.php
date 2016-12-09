<?php

namespace App\Policies;

use App\Forum\Posts\Post;
use App\Forum\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
     * User can only reply to posts that are not closed and they have the ability to create replies
     * @param  User   $user
     * @param  Post   $post
     * @return boolean
     */
    public function reply(User $user, Post $post)
    {
        return $user->can('create-replies') && ! $post->closed;
    }

    /**
     * User can only edit posts that they created or have the ability to edit posts
     * @param  User   $user
     * @param  Post   $post
     * @return boolean
     */
    public function edit(User $user, Post $post)
    {
        return $user->owns($post) || $user->can('edit-posts');
    }

    /**
     * User can delete posts if they own the post or they have the ability to delete posts
     * @param  User   $user
     * @param  Post   $post
     * @return boolean
     */
    public function delete(User $user, Post $post)
    {
        return $user->owns($post) || $user->can('delete-posts');
    }
}
