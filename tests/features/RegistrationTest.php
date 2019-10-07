<?php

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
    function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
             ->type('admin@styde.net', 'email')
             ->type('silence', 'username')
             ->type('Duilio', 'first_name')
             ->type('Palacios', 'last_name')
             ->press('Regístrate');

        $this->seeInDatabase('users', [
            'email' => 'admin@styde.net',
            'username' => 'silence',
            'first_name' => 'Duilio',
            'last_name' => 'Palacios',
        ]);

        $user = User::first();

        $this->seeInDatabase('tokens', [
            'user_id' => $user->id
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id == $token->id;
        });
    }
}
