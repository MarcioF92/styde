<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register/create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();
    }
}
