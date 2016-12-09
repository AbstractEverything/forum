<?php

use App\Forum\Forums\Forum;
use Illuminate\Database\Seeder;

class ForumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Forum::truncate();

        factory(App\Forum\Forums\Forum::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
