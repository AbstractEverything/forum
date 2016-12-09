<?php

namespace App\Forum\Queries;

use App\Forum\Posts\Post;

class GetAllPostsByUser
{
    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * Constructor
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get all the posts posted by a user
     * @param  User    $user
     * @param  integer $perPage
     * @return App\Forum\Posts\Post
     */
    public function run(User $user, $perPage = 20)
    {
        return $this->post->with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }
}