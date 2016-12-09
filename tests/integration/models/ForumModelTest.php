<?php

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Posts\PostMover;
use App\Forum\Queries\GetAllForums;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ForumModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testForumCountsPosts()
    {
        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $posts = factory(App\Forum\Posts\Post::class, 3)->create();
        
        $forum = Forum::find($forum->id);

        $this->assertEquals(3, $forum->postsCount);
    }

    public function testCreatingAPostUpdatesTheForumsLastPostId()
    {
        $user = factory(App\Forum\Forums\Forum::class, 1)->create();
        $forum = factory(App\Forum\Users\User::class, 1)->create();

        auth()->loginUsingId($user->id);

        $post = Post::create([
            'user_id' => $user->id,
            'forum_id' => $forum->id,
            'title' => 'test',
            'body' => 'test',
        ]);

        $forum = Forum::find($forum->id);

        $this->assertEquals($forum->latest_post_id, $post->id);
    }

    public function testForumModelCountsPosts()
    {
        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $posts = factory(App\Forum\Posts\Post::class, 2)->create();

        $forums = App::make(GetAllForums::class)->run();

        $this->assertEquals($forums[0]->postsCount, 2);
    }

    public function testForumModelGetsTheLatestPost()
    {
        $user = factory(App\Forum\Forums\Forum::class, 1)->create();
        $forum = factory(App\Forum\Users\User::class, 1)->create();
        $posts = factory(App\Forum\Posts\Post::class, 2)->create();

        $forums = App::make(GetAllForums::class)->run();

        $this->assertEquals($forums[0]->latestPost->id, 2);
    }
}