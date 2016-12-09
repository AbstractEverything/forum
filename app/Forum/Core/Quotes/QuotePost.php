<?php

namespace App\Forum\Core\Quotes;

use App\Forum\Core\Quotes\Quoteable;
use App\Forum\Posts\Post;

class QuotePost implements Quoteable
{
    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * Constructor
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Find the post and convert it to a quote string
     * @param  integer $id
     * @return string
     */
    public function convert($id)
    {
        $post = $this->post->find($id);
        $quote = '';

        if ($post != null)
        {
            $quote .= '> '.str_replace("\n", "\n> ", $post->body);
            $quote .= "\n\n*Posted by [{$post->user->username}](".route('user.show', $post->user->id).")*";
        }

        return $quote;
    }
}