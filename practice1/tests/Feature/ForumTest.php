<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Forum;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $forum;
    // TODO Testing: Method setUp => Initializer
    protected function setUp ()
    {
        parent::setUp();
        $this->forum = factory(Forum::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testAnyCanBrowseForums()
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('Forums')
            ->assertSee($this->forum->name);
    }

    public function testAnyCanShowForumDetail()
    {
        $response = $this->get('/forums/' . $this->forum->slug);

        $response
            ->assertSee($this->forum->name);
    }

    public function testAnySubmitForums()
    {
        // TODO Require for this Exceptions test
        $this->withExceptionHandling();

        // TODO Testing make() => Create instance (NOT SAVE ON DB)
        $forum = factory(Forum::class)->make(['name' => '']);

        $response = $this->post('/forums', $forum->toArray(), ['HTTP_REFERER' => '/']);

        $response
            ->assertSessionHasErrors('name');

        /**********************************************************/
        
        $forum->name = 'New forum';

        $response = $this->post('/forums', $forum->toArray(), ['HTTP_REFERER' => '/']);

        $response
            ->assertStatus(302)
            ->assertSessionHas('message', ['class' => 'success', 'text' => __('Forum has been created')]);
    }

}
