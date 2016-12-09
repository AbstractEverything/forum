<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Account Validation Rules
    |--------------------------------------------------------------------------
    */
   
   'user' => [
        'first_name' => 'required|max:12',
        'last_name' => 'required|max:12',
        'email' => 'required|email|max:255|unique:users',
        'username' => 'required|between:3,20|unique:users',
        'password' => 'required|confirmed|min:6',
    ],

    /*
    |--------------------------------------------------------------------------
    | Forum Validation Rules
    |--------------------------------------------------------------------------
    */

    'forum' => [
        'name' => 'required|max:255',
        'description' => 'required|max:512',
    ],

    /*
    |--------------------------------------------------------------------------
    | Post Validation Rules
    |--------------------------------------------------------------------------
    */
   
    'post' => [
        'forum_id' => 'required|exists:forums,id',
        'title' => 'required|max:255',
        'body' => 'required',
    ],

    /*
    |--------------------------------------------------------------------------
    | Reply Validation Rules
    |--------------------------------------------------------------------------
    */

    'reply' => [
        'post_id' => 'required|exists:posts,id',
        'title' => 'required|max:255',
        'body' => 'required',
    ],
    
];
