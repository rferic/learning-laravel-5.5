<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Storage;

use App\Forum;
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
        $this->post = factory(Post::class)->make([
            'user_id' => $this->user->id,
            'forum_id' => $this->forum->id
        ]);
    }

    public function testUserLoggedCanSubmitPosts ()
    {
        $this->withExceptionHandling();

        // TODO Testing: Login user
        $this->signIn();

        $this->post->title = null;

        $response = $this->post('/posts', $this->post->toArray(), ['HTTP_REFERER' => '/forums/' . $this->forum->slug]);

        $response->assertSessionHasErrors('title');

        /**********************************************************/

        $this->post->title = 'New test post';

        $response = $this->post('/posts', $this->post->toArray(), ['HTTP_REFERER' => '/forums/' . $this->forum->slug]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('message', ['class' => 'success','text' => __('Post has been created')]);
    }

    public function testOwnerCanDestroyPost ()
    {
        $this->withExceptionHandling();

        // TODO Testing: user => signIn() is than $this->user
        $this->signIn();

        // Create for after can destroy
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id,
            'forum_id' => $this->forum->id
        ]);

        $response = $this->delete('/posts/' . $post->slug, $this->post->toArray());

        $response->assertStatus(401);

        /**********************************************************/

        // TODO Testing: user => signIn($this->user) is equal than $this->user
        $this->signIn($this->user);

        $response = $this->delete('/posts/' . $post->slug, $this->post->toArray());

        $response
            ->assertStatus(302)
            ->assertSessionHas('message', ['class' => 'success', 'text' => __('Post has been removed')]);
    }

    public function testUserLoggedCanUploadFilesToPost ()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $array = $this->post->toArray();

        // TODO Testing: test upload file
        $file = UploadedFile::fake()->image('testFileExists.jpg');
        $array['file'] = $file;

        $this->json('POST', '/posts', $array);

        // TODO Testing: check file exists after upload
        Storage::disk('posts')->assertExists($file->hashName());
        // TODO Testing: check file not exists after upload
        Storage::disk('posts')->assertMissing('testFileNotExists.jpg');
    }
}
