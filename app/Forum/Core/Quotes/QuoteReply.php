<?php

namespace App\Forum\Core\Quotes;

use App\Forum\Core\Quotes\Quoteable;
use App\Forum\Replies\Reply;

class QuoteReply implements Quoteable
{
    /**
     * @var App\Forum\Replies\Reply
     */
    protected $reply;

    /**
     * Constructor
     * @param Reply $reply
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Find the reply and convert it to a quote string
     * @param  integer $id
     * @return string
     */
    public function convert($id)
    {
        $reply = $this->reply->find($id);
        $quote = '';

        if ($reply != null)
        {
            $quote = '> '.str_replace("\n", "\n> ", $reply->body);
            $quote .= "\n\n*Posted by [{$reply->user->username}](".route('user.show', $reply->user->id).")*";
        }

        return $quote;
    }
}