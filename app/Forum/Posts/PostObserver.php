<?php

namespace App\Forum\Posts;

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Queries\UpdateLatestPost;
use Illuminate\Support\Facades\App;

class PostObserver
{
    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * @var App\Forum\Forums\Forum
     */
    protected $forum;

    /**
     * Constructor
     * @param Post  $post
     * @param Forum $forum
     */
    public function __construct(Post $post, Forum $forum)
    {
        $this->post = $post;
        $this->forum = $forum;
    }

    /**
     * Update the latest post id on the forum table
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return null
     */
    public function created($model)
    {
        $model->forum->update([
            'latest_post_id' => $model->id,
        ]);
    }

    /**
     * Update the forums latest post id in that forum
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return null
     */
    public function deleted($model)
    {
        $latestPost = $this->post->latestIn($model->forum_id)->first();

        $model->forum->update([
            'latest_post_id' => ($latestPost == null) ? null : $latestPost->id,
        ]);
    }
}