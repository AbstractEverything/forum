<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('abilities')->truncate();
        DB::table('assigned_roles')->truncate();
        DB::table('forums')->truncate();
        DB::table('password_resets')->truncate();
        DB::table('permissions')->truncate();
        DB::table('posts')->truncate();
        DB::table('posts')->truncate();
        DB::table('replies')->truncate();
        DB::table('roles')->truncate();
        DB::table('sessions')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function tearDown()
    {
        $this->truncateTables();
    }

    public function disableGate()
    {
        Gate::before(function() {
            return true;
        });
    }
}
