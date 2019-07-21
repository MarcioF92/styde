<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 21/07/19
 * Time: 16:46
 */

class CreatePostsTest extends FeatureTestCase
{

    public function test_a_user_create_a_post()
    {

        // Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        $this->actingAs($user = $this->defaultUser())

        // When
            ->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        // Then
        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        // Test a user is redirected to the posts details after creating it.
        $this->see($title);
    }

}