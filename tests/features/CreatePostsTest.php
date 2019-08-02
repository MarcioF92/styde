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

    function test_creating_a_post_requires_authentication()
    {
        // Having
        $this->visit(route('posts.create'))
            ->seePageIs(route('login'));

    }

    function test_create_post_form_validation()
    {
        $this->actingAs($user = $this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio',
            ]);

    }

}