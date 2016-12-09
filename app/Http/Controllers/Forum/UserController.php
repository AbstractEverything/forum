<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Posts\Post;
use App\Forum\Replies\Reply;
use App\Forum\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Role;

class UserController extends Controller
{
    protected $user;
    protected $role;

    /**
     * Constructor
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Show the user
     * @param  integer $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->with('roles')->find($id);
        $posts = $user->latestPosts()->get();
        $replies = $user->latestReplies()->get();
        $roles = $this->role->all();
        $userRoles = $user->roles;

        return view('user.show', compact(
            'user',
            'posts',
            'replies',
            'roles',
            'userRoles'
        ));
    }

    /**
     * Update the user
     * @param  integer  $id
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->authorize('update-roles');

        $input = $request->all();
        
        if ( ! isset($input['roles']))
        {
            $input['roles'] = [];
        }

        $user = $this->user->find($id);
        $user->roles()->sync($input['roles']);

        flash()->success('User roles updated successfully');

        return redirect()->route('user.show', $id);
    }

    /**
     * Ban the user
     * @param  integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function ban($id)
    {
        $user = $this->user->find($id);
        
        $this->authorize('ban', $user);

        if ($user->banned == true)
        {
            $user->update([
                'banned' => false,
            ]);
        }
        else
        {
            $user->update([
                'banned' => true,
            ]);
        }

        flash()->success('User was banned');

        return redirect()->route('user.show', $id);
    }

    /**
     * Display the current users profile
     * @return Illuminate\Http\Response
     */
    public function profile()
    {
        if ( ! auth()->check())
        {
            abort(403, 'You must be logged in to view that page.');
        }

        $user = auth()->user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update the current users profile
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        if ( ! auth()->check())
        {
            abort(403, 'You must be logged in to view that page.');
        }

        $this->validate($request, [
            'first_name' => config('validation.user.first_name'),
            'last_name' => config('validation.user.last_name'),
        ]);

        $user = auth()->user();

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ]);

        return redirect()->route('user.profile');
    }

    /**
     * Update the current users password
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        if ( ! auth()->check())
        {
            abort(403, 'You must be logged in to view that page.');
        }

        $this->validate($request, [
            'old_password' => 'required|check_password',
            'password' => config('validation.user.password'),
        ]);


    }

    public function updateEmail()
    {
        // ...
    }
}
