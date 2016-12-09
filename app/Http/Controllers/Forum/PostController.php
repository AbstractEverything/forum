<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Posts\PostMover;
use App\Forum\Queries\GetAllRepliesToPost;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
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
     * @param Reply           $reply
     * @param DatabaseManager $db
     */
    public function __construct(Forum $forum, Post $post, DatabaseManager $db)
    {
        $this->forum = $forum;
        $this->post = $post;
        $this->db = $db;
    }

    /**
     * Display the create post form
     * @param  integer $id
     * @return Illuminate\Http\Redirect
     */
    public function create($id)
    {
        $forum = $this->forum->find($id);
        
        $this->authorize('create', $forum);

        return view('post.create', compact('forum'));
    }

    /**
     * Create the post in the forum id
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\Redirect
     */
    public function store($id, Request $request)
    {
        $forum = $this->forum->find($id);

        $this->authorize('create', $forum);

        $this->validate($request, [
            'forum_id' => config('validation.post.forum_id'),
            'title' => config('validation.post.title'),
            'body' => config('validation.post.body'),
        ]);

        $this->db->transaction(function() use ($request) {
            $this->post->create([
                'user_id' => auth()->user()->id,
                'forum_id' => $request->input('forum_id'),
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);
        });

        Cache::forget('forums.all');

        flash()->success('Post created successfully');

        return redirect()->route('forum.show', $id);
    }

    /**
     * Show the post and its replies
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $post = $this->post->find($id);

        if ( ! $post)
        {
            abort(404, 'Sorry that post was not found');
        }

        $forumDropdown = $this->forum->lists('name', 'id')->toArray();
        $pageNumber = $request->input('page');
        $replies = App::make(GetAllRepliesToPost::class)->run(
            $id,
            config('pagination.replies')
        );

        $this->incrementViewCount($post);

        return view('post.show', compact(
            'post',
            'replies',
            'forumDropdown',
            'pageNumber'
        ));
    }

    /**
     * Display the edit post form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->post->find($id);

        $this->authorize('edit', $post);

        return view('post.edit', compact('post'));
    }

    /**
     * Update the post
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $post = $this->post->find($id);

        $this->authorize('edit', $post);

        $this->validate($request, [
            'title' => config('validation.post.title'),
            'body' => config('validation.post.body'),
        ]);

        $this->db->transaction(function() use ($request, $post) {
            $post->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);
        });

        flash()->success('Post updated successfully');

        return redirect()->route('post.show', $id);
    }

    /**
     * Display the delete confirmation form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $post = $this->post->find($id);

        $this->authorize('delete', $post);

        return view('post.delete', compact('post'));
    }

    /**
     * Delete the post and its replies
     * @param  integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);

        $this->authorize('delete', $post);

        $this->db->transaction(function() use ($post) {
            $post->delete();
        });

        Cache::forget('forums.all');

        flash()->success('Post deleted successfully');

        return redirect()->route('forum.show', $post->forum->id);
    }

    /**
     * Move the post to a different forum
     * @param  integer    $id
     * @param  Request   $request
     * @param  PostMover $postMover
     * @return Illuminate\Http\RedirectResponse
     */
    public function move($id, Request $request, PostMover $postMover)
    {
        $this->authorize('moderate-posts');

        $this->validate($request, [
            'forum_id' => 'required|exists:forums,id',
        ]);

        $post = $this->post->find($id);

        $postMover->handle(
            $post,
            $post->forum_id,
            $request->input('forum_id')
        );

        Cache::forget('forums.all');

        flash()->success('Post moved successfully');

        return redirect()->route('post.show', $id);
    }

    /**
     * Update the post options
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function options($id, Request $request)
    {
        $this->authorize('moderate-posts');

        $this->validate($request, [
            'pinned' => ['boolean'],
            'closed' => ['boolean'],
        ]);

        $post = $this->post->find($id);
        $post->timestamps = false;
        $post->update([
            'pinned' => ($request->input('pinned') !== null) ? $request->input('pinned') : 0,
            'closed' => ($request->input('closed') !== null) ? $request->input('closed') : 0,
        ]);

        flash()->success('Post options updated successfully');

        return redirect()->route('post.show', $id);
    }

    /**
     * Increment the view count for a post
     * @param  Post   $post
     * @return null
     */
    protected function incrementViewCount(Post $post)
    {
        if (auth()->check())
        {
            $post->timestamps = false;
            $post->increment('views');
        }
    }
}
