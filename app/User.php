<?php

namespace App;

use App\Notifications\PostCommented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Notification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class, 'subscriptions');
    }

    public function createPost(array $data)
    {
        $post = new Post($data);

        auth()->user()->posts()->save($post);

        auth()->user()->subscribeTo($post);

        return $post;
    }

    public function comment($post, $message)
    {
        $comment = new Comment([
            'comment' => $message,
            'post_id' => $post->id,
        ]);
        
        $this->comments()->save($comment);

        // Notify subscribers
        Notification::send(
            $post->subscribers()->where('users.id', '!=', $this->id)->get(),
            new PostCommented($comment)
        );

        return $comment;
    }

    public function subscribeTo(Post $post)
    {
        return $this->subscriptions()->attach($post);
    }

    public function unsubscribeFrom(Post $post)
    {
        return $this->subscriptions()->detach($post);
    }

    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id', $post->id)->count();
    }

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }
}
