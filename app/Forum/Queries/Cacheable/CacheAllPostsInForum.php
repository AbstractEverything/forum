<?php

namespace App\Forum\Queries\Cacheable;

use App\Forum\Forums\Forum;
use App\Forum\Queries\GetAllForums;
use Illuminate\Support\Facades\Cache;

class CacheAllPostsInForum
{
    /**
     * @var App\Forum\Queries\GetAllForums
     */
    protected $getAllPostsInForum;

    /**
     * Constructor
     * @param App\Forum\Queries\GetAllForums $getallForums
     */
    public function __construct(GetAllPostsInForum $getAllPostsInForum)
    {
        $this->getAllPostsInForum = $getAllPostsInForum;
    }

    /**
     * Decorator to cache this query
     * @return mixed
     */
    public function run()
    {
        return Cache::remember('forums.all', config('cache.posts_all.duration'), function() {
            return $this->getAllPostsInForum->run();
        });
    }
}