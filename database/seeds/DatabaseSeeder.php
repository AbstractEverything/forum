<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BouncerTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ForumTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(ReplyTableSeeder::class);
    }
}
