<?php

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ReplyTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanCreateAReply()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('reply/'.$post->id.'/create')
            ->type($post->id, 'post_id')
            ->type('test reply title', 'title')
            ->type('test reply body', 'body')
            ->press('create-new-reply');

        $this->visit('post/'.$post->id)->see('test reply title');
    }

    public function testUserCanDeleteAReply()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();
        $reply = factory(App\Forum\Replies\Reply::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('reply/'.$reply->id.'/confirm-delete')
            ->press('delete-reply');

        $this->visit('post/'.$post->id)->dontSee($reply->title);
    }

    public function testUserCanEditReply()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();
        $reply = factory(App\Forum\Replies\Reply::class, 1)->create();

        auth()->loginUsingId($user->id);

        $this->visit('reply/'.$reply->id.'/edit')
            ->type('edited title', 'title')
            ->press('edit-reply');

        $this->visit('post/'.$post->id)->see('edited title');
    }
}