<?php

use App\Category;
use App\Forum;
use App\Post;
use App\Reply;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(User::class)->create(['email' => 'israel965@yahoo.es']);
    	factory(User::class, 50)->create();
        factory(Forum::class, 20)->create();
        factory(Post::class, 20)->create();
        factory(Reply::class, 30)->create();
        factory(Category::class, 10)->create();
    }
}
