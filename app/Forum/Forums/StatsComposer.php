<?php

namespace App\Forum\Forums;

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Replies\Reply;
use App\Forum\Users\User;
use Illuminate\Contracts\View\View;

class StatsComposer
{
    /**
     * @var App\Forum\Users\User
     */
    protected $user;

    /**
     * @var App\Forum\Forums\Forum
     */
    protected $forum;

    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * @var App\Forum\Replies\Reply
     */
    protected $reply;

    /**
     * Constructor
     * @param User  $user
     * @param Forum $forum
     * @param Post  $post
     * @param Reply $reply
     */
    public function __construct(User $user, Forum $forum, Post $post, Reply $reply)
    {
        $this->user = $user;
        $this->forum = $forum;
        $this->post = $post;
        $this->reply = $reply;
    }

    /**
     * Compose the view
     * @param  View   $view
     * @return null
     */
    public function compose(View $view)
    {
        $view->with([
            'forumsCount' => $this->forum->count(),
            'usersCount' => $this->user->count(),
            'latestUser' => $this->user->latest()->first(),
            'postsCount' => $this->post->count(),
            'repliesCount' => $this->reply->count(),
            'latestPost' => $this->post->with('user')->latest()->first(),
        ]);
    }
}