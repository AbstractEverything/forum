<?php

namespace App\Forum\Forums;

use App\Forum\Forums\ForumPresenter;
use App\Forum\Posts\Post;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Forum extends Model
{
    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = ForumPresenter::class;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'latest_post_id',
        'posts_count',
        'name',
        'description',
        'closed',
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
     * Set up the posts relationship
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(\App\Forum\Posts\Post::class);
    }

    /**
     * Set up the user relationship
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function latestPost()
    {
        return $this->belongsTo(\App\Forum\Posts\Post::class, 'latest_post_id');
    }

    /**
     * Set up the postsCount relationship
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postsCount()
    {
        return $this->hasOne(\App\Forum\Posts\Post::class)
            ->selectRaw('forum_id, COUNT(*) AS aggregate')
            ->groupBy('forum_id');
    }

    /**
     * Set up the repliesCount attribute if it is not loaded already
     * @return integer
     */
    public function getPostsCountAttribute()
    {
        if ( ! $this->relationLoaded('postsCount'))
        {
            $this->load('postsCount');
        }
        
        $related = $this->getRelation('postsCount');
        
        return ($related) ? (int) $related->aggregate : 0;
    }
}
