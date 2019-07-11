<?php

class ExampleTest extends FeatureTestCase
{

    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Marcio Fuentes',
            'email' => 'admin@styde.net',
        ]);

        $this->actingAs($user, 'api')
             ->visit('api/user')
             ->see('Marcio Fuentes')
             ->see('admin@styde.net');
    }
}
