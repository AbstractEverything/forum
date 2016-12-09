<?php

use App\Forum\Forums\Forum;
use App\Forum\Posts\Post;
use App\Forum\Users\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Forum\Users\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Forum\Forums\Forum::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, User::count()),
        'name' => $faker->sentence(rand(1, 8)),
        'description' => $faker->sentence(rand(5, 20)),
    ];
});

$factory->define(App\Forum\Posts\Post::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, User::count()),
        'forum_id' => rand(1, Forum::count()),
        'title' => $faker->sentence(rand(1, 8)),
        'pinned' => false,
        'closed' => false,
        'views' => 0,
        'body' => $faker->paragraph(),
    ];
});

$factory->define(App\Forum\Replies\Reply::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(1, User::count()),
        'post_id' => rand(1, Post::count()),
        'title' => $faker->sentence(rand(1, 8)),
        'body' => $faker->paragraph(),
    ];
});