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

use App\Forum\Posts\Post;
use App\Forum\Users\User;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCustomValidator();

        Bouncer::seeder('BouncerSeeder@run');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local')
        {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }

    protected function registerCustomValidator()
    {
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new \App\Forum\Core\Extensions\Validation\CustomValidator(
                $translator,
                $data,
                $rules,
                $messages
            );
        });
    }
}
