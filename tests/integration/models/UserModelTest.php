<?php

use App\Forum\Users\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCountsPosts()
    {
        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $posts = factory(App\Forum\Posts\Post::class, 2)->create();
        
        $user = User::find($user->id);

        $this->assertEquals(2, $user->postsCount);
    }

    public function testItCountsReplies()
    {
        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $posts = factory(App\Forum\Posts\Post::class, 1)->create();
        $replies = factory(App\Forum\Replies\Reply::class, 2)->create();
        
        $user = User::find($user->id);

        $this->assertEquals(2, $user->repliesCount);
    }
}