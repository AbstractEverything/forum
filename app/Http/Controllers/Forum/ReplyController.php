<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Core\Quotes\NullQuote;
use App\Forum\Core\Quotes\QuotePost;
use App\Forum\Core\Quotes\QuoteReply;
use App\Forum\Posts\Post;
use App\Forum\Replies\Reply;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * @var App\Forum\Posts\Post
     */
    protected $post;

    /**
     * @var App\Forum\Replies\Reply
     */
    protected $reply;

    /**
     * @var Illuminate\Database\DatabaseManager
     */
    protected $db;

    /**
     * Constructor
     * @param Post            $post
     * @param Reply           $reply
     * @param DatabaseManager $db
     */
    public function __construct(Post $post, Reply $reply, DatabaseManager $db)
    {
        $this->post = $post;
        $this->reply = $reply;
        $this->db = $db;
    }

    /**
     * Display the create reply form
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function create($id, Request $request)
    {
        $this->authorize('create-replies');

        $post = $this->post->with('user', 'forum')->find($id);
        $quote = $this->getQuoteStrategy($request->input('type'))->convert($request->input('quote_id'));

        return view('reply.create', compact(
            'post',
            'reply',
            'quote'
        ));
    }

    /**
     * Store the reply
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store($id, Request $request)
    {
        $this->authorize('create-replies');

        $this->validate($request, [
            'post_id' => config('validation.reply.post_id'),
            'title' => config('validation.reply.title'),
            'body' => config('validation.reply.body'),
        ]);

        $this->db->transaction(function() use ($request) {
            $this->reply->create([
                'user_id' => auth()->user()->id,
                'post_id' => $request->input('post_id'),
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);
        });

        flash()->success('Reply posted successfully');

        return redirect()->route('post.show', $id);
    }

    /**
     * Display the edit reply form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reply = $this->reply->find($id);

        $this->authorize('edit', $reply);

        return view('reply.edit', compact('reply'));
    }

    /**
     * Update the reply
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $reply = $this->reply->find($id);

        $this->authorize('edit', $reply);

        $this->validate($request, [
            'title' => config('validation.reply.title'),
            'body' => config('validation.reply.body'),
        ]);

        $this->db->transaction(function() use ($request, $reply) {
            $reply->timestamps = false;
            $reply->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);
        });

        flash()->success('Reply updated successfully');

        return redirect()->route('post.show', $reply->post->id);
    }

    /**
     * Display the delete confirmation form
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function confirmDelete($id)
    {
        $reply = $this->reply->find($id);

        $this->authorize('delete', $reply);

        return view('reply.delete', compact('reply'));
    }

    /**
     * Delete the post
     * @param  integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $reply = $this->reply->find($id);

        $this->authorize('delete', $reply);

        $this->db->transaction(function() use ($reply) {
            $reply->setTouchedRelations([]);
            $reply->delete();
        });

        flash()->success('Reply deleted successfully');

        return redirect()->route('post.show', $reply->post->id);
    }

    /**
     * Resolve the correct type of quote from IOC
     * @param  string $type
     * @return App\Forum\Core\Quotes\Quoteable
     */
    public function getQuoteStrategy($type)
    {
        if ($type == 'post')
        {
            return \App::make(QuotePost::class);
        }

        if ($type == 'reply')
        {
            return \App::make(QuoteReply::class);
        }

        return \App::make(NullQuote::class);
    }
}
