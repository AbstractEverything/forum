<?php

namespace App\Forum\Queries;

use App\Forum\Replies\Reply;

class GetAllRepliesToPost
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
     * Get all replies to a post
     * @param  integer $id
     * @param  integer $perPage
     * @return App\Forum\Replies\Reply
     */
    public function run($id, $perPage)
    {
        return $this->reply->with([
                'user',
                'user.postsCount',
                'user.repliesCount',
            ])
            ->where('post_id', '=', $id)
            ->orderBy('updated_at', 'asc')
            ->paginate($perPage);
    }
}