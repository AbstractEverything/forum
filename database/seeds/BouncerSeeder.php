<?php

use App\Forum\Posts\Post;
use App\Forum\Replies\Reply;
use App\Forum\Users\User;
use Illuminate\Database\Seeder;

class BouncerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('super')->to([
            'delete-forums',
        ]);

        Bouncer::allow('admin')->to([
            'update-roles',
            'ban-users',
            'create-forums',
            'edit-forums',
        ]);

        Bouncer::allow('moderator')->to([
            'edit-posts',
            'delete-posts',
            'edit-replies',
            'delete-replies',
            'moderate-posts',
            'post-in-closed-forums',
            'reply-to-closed-posts',
        ]);

        Bouncer::allow('member')->to([
            'create-posts',
            'create-replies',
        ]);
    }
}
