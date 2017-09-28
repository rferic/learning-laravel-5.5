<?php

use Faker\Generator as Faker;

$factory->define(App\Forum::class, function (Faker $faker) {
    // TODO Tinker => Run PHP sentences in console
    // TODO Run Tinker => php artisan tinker
    // TODO Run Factory with Tinker => factory(App\Forum::class, 50)->create()
    $name = $faker->sentence;

    return [
        'name' => $name,
        'description' => $faker->paragraph,
        'slug' => str_slug($name, '-')
    ];
});
