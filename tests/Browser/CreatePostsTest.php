<?php

namespace Tests\Browser;

use App\Post;
use Laravel\Dusk\Browser as BrowserAlias;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $title = 'Esta es una pregunta';
    protected $content = 'Este es el contenido';

    public function test_a_user_create_a_post()
    {

        // Having
        $user = $this->defaultUser();

        $this->browse(function ($browser) use ($user){
            $browser->loginAs($user)
                ->visit(route('posts.create'))
                ->type('title', $this->title)
                ->type('content', $this->content)
                ->press('Publicar')
                ->assertPathIs('/posts/1-esta-es-una-pregunta');
        });

        // Then
        $this->assertDatabaseHas('posts', [
            'title' => $this->title,
            'content' => $this->content,
            'pending' => true,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta'
        ]);

        $post = Post::first();

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }

    function test_creating_a_post_requires_authentication()
    {
        $this->browse(function($browser){
            $browser->visit(route('posts.create'))
                ->assertPathIs('/login');
        });
    }

    function test_create_post_form_validation()
    {
        $this->browse(function($browser) {
            $browser->loginAs($user = $this->defaultUser())
                ->visit(route('posts.create'))
                ->press('Publicar')
                ->assertPathIs(str_replace(url('/'), '', route('posts.create')))
                ->assertSeeErrors([
                    'title' => 'El campo título es obligatorio',
                    'content' => 'El campo contenido es obligatorio',
                ]);
        });

    }
}
