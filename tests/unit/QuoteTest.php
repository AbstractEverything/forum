<?php

use App\Forum\Core\Quotes\NullQuote;
use App\Forum\Core\Quotes\QuotePost;
use App\Forum\Core\Quotes\QuoteReply;
use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class QuoteTest extends TestCase
{
    use DatabaseTransactions;

    public function testQuotedPostReturnsStringContainingAString()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        $quotePost = \App::make(QuotePost::class)->convert($post->id);

        $this->assertContains('Posted', $quotePost);
    }

    public function testInvalidPostIdReturnsEmptyString()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();

        $quotePost = \App::make(QuotePost::class)->convert(123);

        $this->assertEquals('', $quotePost);
    }

    public function testQuotedReplyReturnsStringContainingAString()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();
        $reply = factory(App\Forum\Replies\Reply::class, 1)->create();

        $postQuote = \App::make(QuoteReply::class)->convert($reply->id);

        $this->assertContains('Posted', $postQuote);
    }

    public function testInvalidReplyIdReturnsEmptyString()
    {
        $this->disableGate();

        $user = factory(App\Forum\Users\User::class, 1)->create();
        $forum = factory(App\Forum\Forums\Forum::class, 1)->create();
        $post = factory(App\Forum\Posts\Post::class, 1)->create();
        $reply = factory(App\Forum\Replies\Reply::class, 1)->create();

        $replyQuote = \App::make(QuoteReply::class)->convert(123);

        $this->assertEquals('', $replyQuote);
    }

    public function testNullQuoteReturnsEmptyString()
    {
        $this->assertEquals('', (new NullQuote())->convert(123));
    }
}