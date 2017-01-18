<?php

namespace App\Forum\Forums;

use App\Forum\Forums\Forum;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Support\Facades\App;

class CacheableForum
{
    /**
     * @var Forum
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
     * Get a cached version of this query
     * @return mixed
     */
    public function overview()
    {
        $cache = App::make(Cache::class);

        return $cache->remember(
            'forums.all',
            config('forum.cache.forums_all.duration'),
            function() {
                return $this->forum->overview()->get();
            }
        );
    }
}