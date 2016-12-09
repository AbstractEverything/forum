<?php

namespace App\Forum\Posts;

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use Exception;
use Illuminate\Database\DatabaseManager;

class PostMover
{
    /**
     * @var App\Forum\Forums\Forum
     */
    protected $forum;

    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * @var Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * Constructor
     * @param Forum           $forum
     * @param Post            $post
     * @param DatabaseManager $db
     */
    public function __construct(Forum $forum, Post $post, DatabaseManager $db)
    {
        $this->forum = $forum;
        $this->post = $post;
        $this->db = $db;
    }

    /**
     * Move the post from one forum to another
     * @param  Post   $post
     * @param  integer $oldForumId
     * @param  integer $newForumId
     * @return null
     */
    public function handle(Post $post, $oldForumId, $newForumId)
    {
        $this->db->beginTransaction();

        try
        {
            $post->timestamps = false;
            $post->update([
                'forum_id' => $newForumId,
                'moved' => true,
            ]);

            $this->updateLatestPost($oldForumId);
            $this->updateLatestPost($newForumId);

            $this->db->commit();
        }
        catch (Exception $e)
        {
            $this->db->rollback();
        }
    }

    /**
     * Update the latest post in a forum
     * @param  integer $id
     * @return null
     */
    public function updateLatestPost($id)
    {
        $latestPost = $this->post->latestIn($id)->first();

        $forum = $this->forum->find($id);
        $forum->update([
            'latest_post_id' => ($latestPost == null) ? null : $latestPost->id,
        ]);
    }
}