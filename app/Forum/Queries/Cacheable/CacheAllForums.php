<?php

namespace App\Forum\Queries\Cacheable;

use App\Forum\Forums\Forum;
use App\Forum\Queries\GetAllForums;
use Illuminate\Support\Facades\Cache;

class CacheAllForums
{
    /**
     * @var App\Forum\Queries\GetAllForums
     */
    protected $getAllForums;

    /**
     * Constructor
     * @param App\Forum\Queries\GetAllForums $getallForums
     */
    public function __construct(GetAllForums $getAllForums)
    {
        $this->getAllForums = $getAllForums;
    }

    /**
     * Decorator to cache this query
     * @return mixed
     */
    public function run()
    {
        return Cache::remember('forums.all', config('cache.forums_all.duration'), function() {
            return $this->getAllForums->run();
        });
    }
}