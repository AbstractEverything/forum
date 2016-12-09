<?php

/*
 * This file is part of Laravel Forum.
 *
 * (c) Rupert Franks <ru.franks@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('forum.partials.stats', \App\Forum\Forums\StatsComposer::class);
        view()->composer('forum.partials.activity', \App\Forum\Forums\ActivityComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}