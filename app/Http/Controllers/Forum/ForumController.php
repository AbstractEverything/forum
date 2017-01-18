<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Forums\CacheableForum;
use App\Forum\Forums\Forum;
use App\Forum\Posts\CacheablePost;
use App\Forum\Posts\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ForumController extends Controller
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
     * Constructor
     * @param Forum $forum
     * @param Post  $post
     */
    public function __construct(Forum $forum, Post $post)
    {
        $this->forum = $forum;
        $this->post = $post;
    }

    /**
     * Show a listing of all forums
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $forums = (new CacheableForum(App::make(Forum::class)))->overview();

        return view('forum.index', compact('forums'));
    }

    /**
     * Display the create forum form
     * @return Illuminate\Http\Redirect
     */
    public function create()
    {
        $this->authorize('create-forums');

        $title = 'Create a new forum';

        return view('forum.create', compact('title'));
    }

    /**
     * Create the forum
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create-forums');

        $this->validate($request, [
            'name' => config('validation.forum.name'),
            'description' => config('validation.forum.description'),
            'closed' => 'boolean',
        ]);

        $this->forum->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'closed' => ($request->input('closed') !== null) ? $request->input('closed') : 0,
        ]);

        Cache::forget('forums.all');

        flash()->success('Forum created successfully');

        return redirect()->route('forum.index');
    }

    /**
     * Display the edit forum form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-forums');

        $forum = $this->forum->find($id);
        $title = $forum->title;

        return view('forum.edit', compact(
            'forum',
            'title'
        ));
    }

    /**
     * Update the forum 
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->authorize('edit-forums');

        $this->validate($request, [
            'name' => config('validation.forum.name'),
            'description' => config('validation.forum.description'),
            'closed' => 'boolean',
        ]);

        $forum = $this->forum->find($id);

        $forum->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'closed' => ($request->input('closed') !== null) ? $request->input('closed') : 0,
        ]);

        Cache::forget('forums.all');

        flash()->success('Forum updated successfully');

        return redirect()->route('forum.index');
    }

    /**
     * Display the delete forum confirmation form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $forum = $this->forum->find($id);

        $this->authorize('delete-forums');

        return view('forum.delete', compact('forum'));
    }

    /**
     * Delete the forum including all posts and replies
     * @param  integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $forum = $this->forum->find($id);
        $forum->posts()->delete();
        $forum->delete();

        Cache::forget('forums.all');

        flash()->success('Forum deleted successfully');

        return redirect()->route('forum.index');
    }

    /**
     * Show a listing of all posts in a forum
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $forum = $this->forum->find($id);

        if ( ! $forum)
        {
            abort(404, 'Sorry that forum was not found');
        }

        $posts = $this->post->allInForum($id)->paginate(config('pagination.posts'));
        $pinnedPosts = $this->post->pinnedInForum($id);

        return view('forum.show', compact(
            'forum',
            'posts',
            'pinnedPosts'
        ));
    }
}
