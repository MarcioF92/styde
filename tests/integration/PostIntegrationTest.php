<?php

use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    public function test_a_slug_is_generated_and_saved_to_the_database()
    {

        $post = $this->createPost([
            'title' => 'Como instalar Laravel',
        ]);

        /*$this->seeInDatabase('posts', [
            'slug' => 'como-instalar-laravel'
        ]);

        $this->assertSame(
            'como-instalar-laravel',
            $post->slug
        );*/

        $this->assertSame(
            'como-instalar-laravel',
            $post->fresh()->slug
        );
    }
}
