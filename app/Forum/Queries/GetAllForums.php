<?php

namespace App\Forum\Queries;

use App\Forum\Forums\Forum;

class GetAllForums
{
    /**
     * @var App\Forum\Forums\Forum
     */
    protected $forum;

    /**
     * Constructor
     * @param Forum $forum
     */
    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
    }

    /**
     * Get all the forums with relationships to display on the front page
     * @return App\Forum\Forums\Forum
     */
    public function run()
    {
        return $this->forum->with([
                'postsCount',
                'latestPost',
                'latestPost.user',
            ])
            ->get();
    }
}