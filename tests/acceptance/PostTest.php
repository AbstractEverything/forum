<?php

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanCreateAPost()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('post/'.$forum->id.'/create')
            ->type($forum->id, 'forum_id')
            ->type('test title', 'title')
            ->type('test body', 'body')
            ->press('create-new-post');

        $this->visit($forum->id)->see('test title');
    }

    public function testUserCanDeleteAPost()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('post/'.$post->id)->see($post->title);
        $this->visit('post/'.$post->id.'/confirm-delete')->press('delete-post');
        $this->visit($forum->id)->dontSee($post->title);
    }

    public function testUserCanEditPost()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('post/'.$post->id.'/edit')
            ->type('edited title', 'title')
            ->press('edit-post');

        $this->visit('post/'.$post->id)->see('edited title');
    }

    public function testViewingAPostUpdatesItsCount()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('post/'.$post->id);
        $this->assertEquals(1, Post::find($post->id)->views);
    }

    public function testUserCanUpdatePostOptions()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forums = factory(App\Forum\Forums\Forum::class, 2)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->call('PATCH', 'post/'.$post->id.'/options', [
            'pinned' => true,
        ]);

        $this->assertEquals(Post::find($post->id)->pinned, true);
    }

    public function testUserCanMoveAPost()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forums = factory(App\Forum\Forums\Forum::class, 2)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create([
            'forum_id' => $forums[0]->id,
        ]);

        auth()->loginUsingId($user->id);

        $this->call('PATCH', 'post/'.$post->id.'/move', [
            'forum_id' => $forums[1]->id,
        ]);

        $this->assertEquals(Post::find($post->id)->forum_id, $forums[1]->id);
    }
}