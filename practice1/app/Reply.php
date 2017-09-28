<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

use App\Notifications\NewReply;

class Reply extends Model
{
    protected $fillable = ['reply', 'attachment', 'user_id', 'post_id'];

    // TODO Specificate Attribute for Indirect Table Relation
    protected $happens = ['forum'];

    // TODO Events on Model
    protected static function boot ()
    {
        parent::boot();

        static::creating(function ($reply) {
            // TODO Running Console check
            // TODO Include param for assign Action to User
            if ( !App::runningInConsole() )
            {
                $reply->user_id = auth()->id();
                // TODO Notification trigger
                self::notifyPostOwner($reply);
            }
        });

        static::deleting(function ($reply) {
            if ( !App::runningInConsole() )
            {
                if ($reply->attachment)
                {
                    Storage::delete('replies/' . $reply->attachment);
                }
            }
        });
    }

    public function post ()
    {
        return $this->belongsTo(Post::class);
    }

    public function author ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAuthor ()
    {
        return $this->author->id === auth()->id();
    }

    // TODO Available Indirect Table Relation
    public function getForumAttribute ()
    {
        return $this->post->forum;
    }

    public function pathAttachment ()
    {
        return '/images/replies/' . $this->attachment;
    }

    public static function notifyPostOwner ($reply)
    {
        // TODO Call Notification
        $reply->post->owner->notify(new NewReply ($reply));
    }
}
