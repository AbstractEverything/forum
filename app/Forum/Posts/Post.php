<?php

namespace App\Forum\Posts;

use App\Forum\Posts\PostPresenter;
use App\Forum\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Laracasts\Presenter\PresentableTrait;

class Post extends Model
{
    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = PostPresenter::class;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'forum_id',
        'latest_reply_id',
        'title',
        'body',
        'pinned',
        'closed',
        'views',
        'moved',
    ];

    /**
     * Get all the pinned posts in a forum
     * @param  integer $id
     * @return App\Forum\Posts\Post
     */
    public function pinnedInForum($id)
    {
        return static::with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('forum_id', $id)
            ->where('pinned', true)
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Get all the posts in a forum
     * @param  integer $id
     * @return App\Forum\Posts\Post
     */
    public function allInForum($id)
    {
        return static::with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('forum_id', $id)
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Get all the posts posted by a user
     * @param  User    $user
     * @return App\Forum\Posts\Post
     */
    public function allByUser(User $user)
    {
        return static::with([
                'user',
                'repliesCount',
                'latestReply',
                'latestReply.user',
            ])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Determine if the post is closed or pinned
     * @return boolean
     */
    public function hasOptions()
    {
        return $this->pinned || $this->closed;
    }

    /**
     * Determine if the post is popular
     * @return boolean
     */
    public function isHot()
    {
        return $this->repliesCount >= config('forum.hot_post');
    }

    // Scopes
    // ----------------------------------------------------------------------

    /**
     * Get the latest posts in the forum ordered by by when they were updated
     * @param  Illuminate\Database\Eloquent\Model $query
     * @param  integer $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function scopeLatestIn($query, $id)
    {
        return $query->where('forum_id', $id)->orderBy('updated_at', 'desc'); 
    }

    // Relationships
    // ----------------------------------------------------------------------

    /**
     * Set up the user relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Forum\Users\User::class);
    }

    /**
     * Set up the forum relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum()
    {
        return $this->belongsTo(\App\Forum\Forums\Forum::class);
    }

    /**
     * Set up the replies relationship
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(\App\Forum\Replies\Reply::class);
    }

    /**
     * Set up the latestReply relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function latestReply()
    {
        return $this->belongsTo(\App\Forum\Replies\Reply::class, 'latest_reply_id');
    }

    /**
     * Set up the repliesCount relationship
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function repliesCount()
    {
        return $this->hasOne(\App\Forum\Replies\Reply::class)
            ->selectRaw('post_id, COUNT(*) AS aggregate')
            ->groupBy('post_id');
    }

    /**
     * Set up the repliesCount attribute if it is not loaded already
     * @return integer
     */
    public function getRepliesCountAttribute()
    {
        if ( ! $this->relationLoaded('repliesCount'))
        {
            $this->load('repliesCount');
        }
        
        $related = $this->getRelation('repliesCount');
        
        return ($related) ? (int) $related->aggregate : 0;
    }
}
