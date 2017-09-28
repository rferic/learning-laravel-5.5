<?php

use Faker\Generator as Faker;

use Faker\Provider\Image;

$factory->define(App\Post::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        // TODO Asign random IDS
        'title' => $title,
        'description' => $faker->paragraph,
        'slug' => str_slug($title, '-'),
        'attachment' => Image::image(storage_path() . '/app/posts', 200, 200, 'technics', false),
        'user_id' => App\User::all()->random()->id,
        'forum_id' => App\Forum::all()->random()->id
    ];
});
