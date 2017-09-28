<?php

use Faker\Generator as Faker;
use Faker\Provider\Image;

use App\User;
use App\Post;

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'reply' => $faker->paragraph,
        'attachment' => Image::image(storage_path() . '/app/replies', 200, 200, 'technics', false),
        'user_id' => User::all()->random()->id,
        'post_id' => Post::all()->random()->id
    ];
});
