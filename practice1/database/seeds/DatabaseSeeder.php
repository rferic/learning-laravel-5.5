<?php

use Illuminate\Database\Seeder;
use App\Forum;
use App\Post;
use App\User;
use App\Reply;
use App\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO Seeder
        // TODO Run Seeder: php artisan migrate:fresh --seed
        // TODO Remove all tables and new create
        // TODO After run Seeder
        factory(User::class, 1)->create(['email' => 'erf@mail.com']);
        factory(User::class, 50)->create();
        factory(Forum::class, 20)->create();
        factory(Post::class, 50)->create();
        factory(Reply::class, 100)->create();
        factory(Category::class, 10)->create();
    }
}
