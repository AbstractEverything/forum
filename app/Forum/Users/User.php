<?php

namespace App\Forum\Users;

use App\Forum\Users\UserPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laracasts\Presenter\PresentableTrait;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use PresentableTrait, HasRolesAndAbilities;

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'banned',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string
     */
    protected $presenter = UserPresenter::class;

    /**
     * Set up the posts relationship
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(\App\Forum\Posts\Post::class);
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
     * Bcrypt the password attribute before saving
     * @return null
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Figure out if the model is owned by the current user
     * @param  Model  $related
     * @return boolean
     */
    public function owns(Model $related)
    {
        return $this->id == $related->user_id;
    }

    /**
     * Set up the postsCount relationship
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postsCount()
    {
        return $this->hasOne(\App\Forum\Posts\Post::class)
            ->selectRaw('user_id, COUNT(*) AS aggregate')
            ->groupBy('user_id');
    }

    /**
     * Set up the postsCount attribute if it is not loaded already
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

    /**
     * Set up the repliesCount relationship
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function repliesCount()
    {
        return $this->hasOne(\App\Forum\Replies\Reply::class)
            ->selectRaw('user_id, COUNT(*) AS aggregate')
            ->groupBy('user_id');
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

    /**
     * Scope the latest posts
     * @param  Illuminate\Database\Eloquent\Model  $query
     * @param  integer $limit
     * @return Illuminate\Database\Eloquent\Model
     */
    public function scopeLatestPosts($query, $limit = 5)
    {
        return $this->posts()->orderBy('updated_at', 'desc')->limit($limit);
    }

    /**
     * Scope the latest replies
     * @param  Illuminate\Database\Eloquent\Model  $query
     * @param  integer $limit
     * @return Illuminate\Database\Eloquent\Model
     */
    public function scopeLatestReplies($query, $limit = 5)
    {
        return $this->replies()->orderBy('updated_at', 'desc')->limit($limit);
    }
}