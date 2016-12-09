<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ForumTest extends TestCase
{
    use DatabaseTransactions;

    public function testHomePageLoads()
    {
        $this->visit('/')->see('Forums');
    }

    public function testLinksToCorrectForum()
    {
        $this->disableGate();

        $forum = factory(App\Forum\Forums\Forum::class)->create();

        $this->visit('/')
            ->click($forum->name)
            ->see($forum->name)
            ->seePageIs('/'.$forum->id);
    }

    public function testLinksToLatestPost()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class)->create();
        $forum = factory(App\Forum\Forums\Forum::class)->create();
        $post = factory(App\Forum\Posts\Post::class)->create();

        $this->visit('/')
            ->click($post->title)
            ->see($post->title)
            ->seePageIs('post/'.$post->id);
    }

    public function testShowErrorMessageIfForumIsEmpty()
    {
        $forum = factory(App\Forum\Forums\Forum::class)->create();

        $this->visit('/'.$forum->id)
            ->see('No posts yet.');
    }

    public function testUserCanCreateAForum()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        auth()->loginUsingId($user->id);

        $this->visit('forum/create')
            ->type('test forum name', 'name')
            ->type('test forum description', 'description')
            ->press('create-new-forum');

        $this->visit('/')->see('test forum name');
    }

    public function testUserCanEditAForum()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        auth()->loginUsingId($user->id);

        $this->visit('forum/'.$forum->id.'/edit')
            ->type('test forum updated', 'name')
            ->press('update-forum');

        $this->visit('/')->see('test forum updated');
    }

    public function testUserCanDeleteAForum()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        auth()->loginUsingId($user->id);

        $this->visit('forum/'.$forum->id.'/confirm-delete')
            ->press('delete-forum');

        $this->visit('/')->dontSee($forum->name);
    }

    public function testWhenAForumIsDeletedItsPostsAndRepliesAreAlsoDeleted()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class)->create();
        $forum = factory(App\Forum\Forums\Forum::class)->create();
        $post = factory(App\Forum\Posts\Post::class)->create();
        $reply = factory(App\Forum\Replies\Reply::class)->create();
        auth()->loginUsingId($user->id);

        $this->visit('forum/'.$forum->id.'/confirm-delete')
            ->press('delete-forum');

        $this->assertEquals(App\Forum\Posts\Post::find($post->id), null);
        $this->assertEquals(App\Forum\Replies\Reply::find($reply->id), null);
    }

    public function testForumWithNoPostsDisplaysNoPostsMessage()
    {
        $user = factory(App\Forum\Users\User::class)->create();
        $forum = factory(App\Forum\Forums\Forum::class)->create();

        $this->visit('/')->see('No posts');
    }
}