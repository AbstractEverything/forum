<?php

namespace App\Forum\Queries;

use App\Forum\Posts\Post;

class GetAllPostsInForum
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
     * Get all the posts in forum with $id
     * @param  integer $id
     * @param  integer $perPage
     * @return App\Forum\Posts\Post
     */
    public function run($id, $perPage)
    {
        return $this->post->with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('forum_id', $id)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }
}