<?php

namespace App\Forum\Queries;

use App\Forum\Posts\Post;

class GetPinnedPostsInForum
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
     * Get all the pinned posts for a forum
     * @param  integer $id
     * @return App\Forum\Posts\Post
     */
    public function run($id)
    {
        return $this->post->with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('forum_id', $id)
            ->where('pinned', true)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}