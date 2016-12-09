<?php

namespace App\Forum\Replies;

use App\Forum\Replies\ReplyPresenter;
use App\Forum\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Reply extends Model
{
    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = ReplyPresenter::class;

    /**
     * @var array
     */
    protected $touches = ['post'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'title',
        'body',
    ];

    /**
     * Set up the user relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Forum\Users\User::class);
    }

    /**
     * Set up the post relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(\App\Forum\Posts\Post::class);
    }
}
