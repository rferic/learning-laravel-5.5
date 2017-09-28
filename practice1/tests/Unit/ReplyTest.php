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

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum, $user, $post, $reply;

    protected function setUp ()
    {
        parent::setUp();

        $this->forum = factory(Forum::class)->create();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create([
            'user_id' => $this->user->id,
            'forum_id' => $this->forum->id
        ]);
        $this->reply = factory(Reply::class)->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id
        ]);
    }

    public function testReplyIsRelatedWithAForum ()
    {
        $this->assertInstanceOf(Forum::class, $this->reply->forum);
    }

    public function testReplyBelongsToAuthor ()
    {
        $this->assertInstanceOf(User::class, $this->reply->author);
    }

    public function testReplyBelongsToPost ()
    {
        $this->assertInstanceOf(Post::class, $this->reply->post);
    }
}
