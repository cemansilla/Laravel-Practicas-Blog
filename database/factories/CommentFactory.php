<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $users_count = User::count();
    $posts_count = Post::count();

    return [
        'comment' => $faker->text($maxNbChars = 100),
        'user_id' => $faker->numberBetween(1, $users_count),
        'post_id' => $faker->numberBetween(1, $posts_count)
    ];
});
