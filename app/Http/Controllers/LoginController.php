<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Token $token)
    {
        Auth::login($token->user);
        $token->delete();
        return redirect('/');
    }
}
