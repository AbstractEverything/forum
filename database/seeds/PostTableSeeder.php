<?php

use App\Forum\Posts\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Post::truncate();

        factory(App\Forum\Posts\Post::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
