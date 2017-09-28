<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

use App\Category;

use App\Http\Helpers\CategoryHelper;

class Post extends Model
{
    protected $fillable = [ 'title', 'description', 'slug', 'attachment', 'forum_id', 'user_id' ];

    // TODO Events on Model
    protected static function boot ()
    {
        parent::boot();

        // TODO Before Create Event
        static::creating(function ($post) {
            // TODO Running Console check
            // TODO Include param for assign Action to User
            if ( !App::runningInConsole() )
            {
                $post->user_id = auth()->id();
                $post->slug = str_slug($post->title, '-');
            }
        });

        // TODO Before Delete Event
        static::deleting(function ($post) {
            if ( !App::runningInConsole() )
            {
                if ($post->replies()->count())
                {
                    foreach ($post->replies AS $reply)
                    {
                        if ($reply->attachment)
                        {
                            Storage::delete('replies/' . $reply->attachment);
                        }

                        $post->replies()->delete();
                    }
                }

                if ($post->attachment)
                {
                    Storage::delete('posts/' . $post->attachment);
                }

                // TODO Remove Relations from Pivot Table
                $post->categories()->detach();
            }
        });

        // TODO After Create Event
        static::created(function ($post) {
            if ( !App::runningInConsole() )
            {
                // TODO Save params on Pivot Table
                $post->categories()->attach(request('categories'));

                /* TODO If nessted push more columns

                $post->categories()->attach(request('categories'), [
                    '{columns}' => '{value}'
                ]);

                */
            }
        });
    }

    // TODO Specificate column for GETTER
    public function getRouteKeyName ()
    {
        return 'slug';
    }

    public function forum ()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function owner ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies ()
    {
        return $this->hasMany(Reply::class);
    }

    public function isOwner ()
    {
        return $this->owner->id === auth()->id();
    }

    public function categories ()
    {
        return $this->belongsToMany(Category::class);
    }

    public function showCategories ($categories, $label)
    {
        return CategoryHelper::showCategories($categories, $label);
    }

    // TODO Getter Image Full Path
    public function pathAttachment ()
    {
        return '/images/posts/' . $this->attachment;
    }
}
