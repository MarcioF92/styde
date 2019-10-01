<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Post $post)
    {
        auth()->user()->subscribeTo($post);
        return redirect($post->url);
    }

    public function unsubscribe(Post $post)
    {
        auth()->user()->unsubscribeFrom($post);
        return redirect($post->url);
    }
}
