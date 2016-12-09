<?php

use App\Forum\Replies\Reply;
use Illuminate\Database\Seeder;

class ReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Reply::truncate();

        factory(App\Forum\Replies\Reply::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
