<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    // Auth
    // ----------------------------------------------------------------------

    Route::auth();

    // Forums
    // ----------------------------------------------------------------------

    Route::get('/', [
        'as' => 'forum.index',
        'uses' => 'Forum\ForumController@index',
    ]);

    Route::get('{id}', [
        'as' => 'forum.show',
        'uses' => 'Forum\ForumController@show',
    ])->where('id', '[0-9]+');

    Route::get('forum/create', [
        'as' => 'forum.create',
        'uses' => 'Forum\ForumController@create',
    ]);

    Route::post('forum', [
        'as' => 'forum.store',
        'uses' => 'Forum\ForumController@store',
    ]);

    Route::get('forum/{id}/edit', [
        'as' => 'forum.edit',
        'uses' => 'Forum\ForumController@edit',
    ])->where('id', '[0-9]+');

    Route::patch('forum/{id}', [
        'as' => 'forum.update',
        'uses' => 'Forum\ForumController@update',
    ])->where('id', '[0-9]+');

    Route::get('forum/{id}/confirm-delete', [
        'as' => 'forum.confirm-delete',
        'uses' => 'Forum\ForumController@confirmDelete',
    ])->where('id', '[0-9]+');

    Route::delete('forum/{id}', [
        'as' => 'forum.destroy',
        'uses' => 'Forum\ForumController@destroy',
    ])->where('id', '[0-9]+');

    // Posts
    // ----------------------------------------------------------------------

    Route::get('post/{id}', [
        'as' => 'post.show',
        'uses' => 'Forum\PostController@show',
    ])->where('id', '[0-9]+');

    Route::get('post/{id}/create', [
        'as' => 'post.create',
        'uses' => 'Forum\PostController@create',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::post('post/{id}', [
        'as' => 'post.store',
        'uses' => 'Forum\PostController@store',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('post/{id}/edit', [
        'as' => 'post.edit',
        'uses' => 'Forum\PostController@edit',
        'middleware' => ['banned'],
    ]);

    Route::patch('post/{id}', [
        'as' => 'post.update',
        'uses' => 'Forum\PostController@update',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('post/{id}/confirm-delete', [
        'as' => 'post.confirm-delete',
        'uses' => 'Forum\PostController@confirmDelete',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::delete('post/{id}', [
        'as' => 'post.destroy',
        'uses' => 'Forum\PostController@destroy',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::patch('post/{id}/move', [
        'as' => 'post.move',
        'uses' => 'Forum\PostController@move',
        'middleware' => ['banned'],
    ]);

    Route::patch('post/{id}/options', [
        'as' => 'post.options',
        'uses' => 'Forum\PostController@options',
        'middleware' => ['banned'],
    ]);

    // Replies
    // ----------------------------------------------------------------------

    Route::post('reply/{id}', [
        'as' => 'reply.store',
        'uses' => 'Forum\ReplyController@store',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('reply/{id}/create', [
        'as' => 'reply.create',
        'uses' => 'Forum\ReplyController@create',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('reply/{id}/edit', [
        'as' => 'reply.edit',
        'uses' => 'Forum\ReplyController@edit',
        'middleware' => ['banned'],
    ]);

    Route::patch('reply/{id}', [
        'as' => 'reply.update',
        'uses' => 'Forum\ReplyController@update',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('reply/{id}/confirm-delete', [
        'as' => 'reply.confirm-delete',
        'uses' => 'Forum\ReplyController@confirmDelete',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::delete('reply/{id}', [
        'as' => 'reply.destroy',
        'uses' => 'Forum\ReplyController@destroy',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    // Users
    // ----------------------------------------------------------------------

    Route::get('user/{id}', [
        'as' => 'user.show',
        'uses' => 'Forum\UserController@show',
    ])->where('id', '[0-9]+');

    Route::patch('user/{id}', [
        'as' => 'user.update',
        'uses' => 'Forum\UserController@update',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::patch('user/ban/{id}', [
        'as' => 'user.ban',
        'uses' => 'Forum\UserController@ban',
        'middleware' => ['banned'],
    ])->where('id', '[0-9]+');

    Route::get('profile', [
        'as' => 'user.profile',
        'uses' => 'Forum\UserController@profile',
    ]);

    Route::patch('profile', [
        'as' => 'user.update-profile',
        'uses' => 'Forum\UserController@updateProfile',
        'middleware' => ['banned'],
    ]);

    Route::patch('profile/update-password', [
        'as' => 'user.update_password',
        'uses' => 'Forum\UserController@updatePassword',
        'middleware' => ['banned'],
    ]);

    Route::patch('profile/update-email', [
        'as' => 'user.update_email',
        'uses' => 'Forum\UserController@updateEmail',
        'middleware' => ['banned'],
    ]);
});
