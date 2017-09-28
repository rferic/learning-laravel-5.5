<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Database\Eloquent\Collection;
use App\Forum;
use App\Reply;
use App\User;
use App\Post;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum, $user, $post;

    protected function setUp ()
    {
        parent::setUp();

        $this->forum = factory(Forum::class)->create();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class, 5)->create([
            'user_id' => $this->user->id,
            'forum_id' => $this->forum->id
        ]);
    }

    public function testForumHasPosts ()
    {
        // TODO Testing Model: Check COUNT
        $this->assertCount(5, $this->forum->posts);
        // TODO Check instance is type of Collection
        $this->assertInstanceOf(Collection::class, $this->forum->posts);
    }

    public function testForumHasReplies ()
    {
        factory(Reply::class, 5)->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->first()->id
        ]);

        $this->assertCount(5, $this->forum->replies);
        $this->assertInstanceOf(Collection::class, $this->forum->replies);
    }

    public function testCanSearchPosts ()
    {
        $this->withExceptionHandling();
        $search = 'post';

        $forum1 = factory(Forum::class)->create(['name' => 'missing']);
        $forum2 = factory(Forum::class)->create(['name' => $search]);

        $this->post('/forums/search', ['search' => $search]);

        $response = $this->get('/');

        $response
            ->assertSessionHas('search')
            ->assertSee($forum2->name)
            ->assertDontSee($forum1->name);

        $this->post('/forums/search', []);

        $response = $this->get('/');

        $response
            ->assertSessionMissing('search')
            ->assertSee($forum1->name)
            ->assertSee($forum2->name);
    }
}
