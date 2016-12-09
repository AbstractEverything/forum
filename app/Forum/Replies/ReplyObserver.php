<?php

namespace App\Forum\Replies;

use App\Forum\Replies\Reply;

class ReplyObserver
{
    /**
     * @var App\Forum\Replies\Reply
     */
    protected $reply;

    /**
     * Construct
     * @param Reply $reply
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Update the reply count and the latest reply id on the post model
     * Update the latest post id on the forum model
     * @param  Illuminate\Database\Eloquent $model
     * @return null
     */
    public function created($model)
    {
        $model->post->update([
            'latest_reply_id' => $model->id,
        ]);

        $model->post->forum->update([
            'latest_post_id' => $model->post->id
        ]);
    }

    /**
     * Update the posts latest reply id in that post
     * @param  Illuminate\Database\Eloquent $model $model
     * @return null
     */
    public function deleted($model)
    {
        $latestReply = $this->reply->where('post_id', $model->post->id)
            ->orderBy('updated_at', 'desc')
            ->first();

        $latestReplyId = ($latestReply == null) ? null : $latestReply->id;

        $model->post->timestamps = false;
        $model->post->update([
            'latest_reply_id' => $latestReplyId,
        ]);
    }
}