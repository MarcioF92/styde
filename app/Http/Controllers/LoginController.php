<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login($token)
    {
        $token = Token::findActive($token);

        if($token == null){
            alert('Este enlace ya expiró, por favor solicita otro', 'danger');
            return redirect()->route('token');
        }

        $token->login();

        return redirect('/');
    }
}
