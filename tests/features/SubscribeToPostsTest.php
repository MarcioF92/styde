<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToPostsTest extends TestCase
{
    function test_a_user_can_subscribe_to_a_post()
    {
        $post = $this->createPost();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        // When
        $this->visit($post->url)
            ->press('Suscribirse al post');

        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->seePageIs($post->url)
            ->dontSee('Suscribirse al post');
    }
    
    function test_a_user_can_unsuscribe_from_a_post()
    {
        $post = $this->createPost();

        $user = factory(User::class)->create();

        $user->subscribeTo($post);

        $this->actingAs($user);

        $this->visit($post->url)
            ->dontSee('Suscribirse al post')
            ->press('Desuscribirse del post');

        $this->dontSeeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url);
    }
}
