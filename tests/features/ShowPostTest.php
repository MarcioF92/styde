<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_the_post_details()
    {
        $user = $this->defaultUser([
            'name' => 'Duilio Palacios',
        ]);

        // Having
        $post = $this->createPost([
            'title' => 'Este es el titulo del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id
        ]);

        $user->posts()->save($post);

        // When
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see('Duilio Palacios');
    }

    function test_old_urls_are_redirected()
    {

        // Having
        $post = $this->createPost(['title' => 'Old title']);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }

    function test_post_url_with_wrong_slug_still_work()
    {
        $user = $this->defaultUser();

        // Having
        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->assertResponseStatus(200)
            ->see('New title');
    }
}
