<?php

namespace App\Providers;

use App\Forum\Posts\Post;
use App\Forum\Posts\PostObserver;
use App\Forum\Replies\Reply;
use App\Forum\Replies\ReplyObserver;
use Illuminate\Support\ServiceProvider;

class ForumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModelObservers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function registerModelObservers()
    {
        Post::observe(PostObserver::class);
        Reply::observe(ReplyObserver::class);
    }
}
