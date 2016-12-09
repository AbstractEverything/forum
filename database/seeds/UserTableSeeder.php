<?php

use App\Forum\Users\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();

        $this->createAdminUser();
        $this->createTestUser();

        factory(App\Forum\Users\User::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    protected function createAdminUser()
    {
        $user = User::create([
            'username' => 'admin',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@admin.com',
            'password' => 'secret',
        ]);

        Bouncer::assign('super')->to($user);
        Bouncer::assign('admin')->to($user);
        Bouncer::assign('moderator')->to($user);
        Bouncer::assign('member')->to($user);
    }

    protected function createTestUser()
    {
        $user = User::create([
            'username' => 'test',
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@test.com',
            'password' => 'test',
        ]);

        Bouncer::assign('member')->to($user);
    }
}
