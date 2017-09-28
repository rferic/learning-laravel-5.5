<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Collection;

use App\Forum;
use App\Reply;
use App\Category;
use App\User;
use App\Post;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum, $user, $post;

    protected function setUp ()
    {
        parent::setUp();

        $this->forum = factory(Forum::class)->create();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create([
            'user_id' => $this->user->id,
            'forum_id' => $this->forum->id
        ]);
    }

    public function testPostBelongsToForum ()
    {
        // TODO Testing Model: Check Instance Type
        $this->assertInstanceOf(Forum::class, $this->post->forum);
    }

    public function testPostBelongsToOwner ()
    {
        $this->assertInstanceOf(User::class, $this->post->owner);
    }

    public function testPostHasCategories ()
    {
        $categories = factory(Category::class, 5)->create();

        // TODO pluck() => return a Array to param
        $this->post->categories()->attach($categories->pluck('id'));

        $this->assertCount(5, $this->post->categories);
        $this->assertInstanceOf(Collection::class, $this->post->categories);
    }

    public function testPostHasReplies ()
    {
        factory(Reply::class, 10)->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id
        ]);

        $this->assertCount(10, $this->post->replies);
        $this->assertInstanceOf(Collection::class, $this->post->replies);
        $this->assertInstanceOf(Reply::class, $this->post->replies->first());
    }
}
