<?php

namespace App\Providers;

use App\Forum\Acl\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Forum\Users\User::class => \App\Policies\UserPolicy::class,
        \App\Forum\Forums\Forum::class => \App\Policies\ForumPolicy::class,
        \App\Forum\Posts\Post::class => \App\Policies\PostPolicy::class,
        \App\Forum\Replies\Reply::class => \App\Policies\ReplyPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
