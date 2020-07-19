<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $users_count = User::count();

    return [
        'title' => $faker->name,
        'content' => $faker->text($maxNbChars = 50),
        'user_id' => $faker->numberBetween(1, $users_count)
    ];
});
