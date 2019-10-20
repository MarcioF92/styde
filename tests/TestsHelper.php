<?php

namespace Tests;

use App\Post;
use App\User;

trait TestsHelper
{
    protected $defaultUser;

    public function defaultUser(array $attributes = [])
    {
        if($this->defaultUser) {
            return $this->defaultUser;
        }

        return $this->defaultUser = factory(User::class)->create($attributes);
    }

    protected function createPost(array $attributes = [])
    {
        return factory(Post::class)->create($attributes);
    }
}