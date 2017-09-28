<?php

namespace App;

use Illuminate\Database\Eloquent\Builder; // TODO Is required for queries with Eloquent
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

use Illuminate\Auth\EloquentUserProvider;

class Forum extends Model
{
    protected $fillable = [ 'name', 'description', 'slug' ];

	protected static function boot()
    {
		parent::boot();

		static::creating(function($forum) {
			if( ! App::runningInConsole() ) {
				$forum->slug = str_slug($forum->name, "-");
			}
		});
	}

    // TODO Specificate column for GETTER
    public function getRouteKeyName ()
    {
        return 'slug';
    }

    public function posts ()
    {
        return $this->hasMany(Post::class);
    }

    // TODO Indirect Table Relation
    public function replies ()
    {
        return $this->hasManyThrough(Reply::class, Post::class);
    }

    // TODO Scopes => select queries
    // TODO scope+Name
    public function scopeSearch (Builder $query)
    {
        // TODO Queries with Eloquent
        $result = $query->with(['replies', 'posts']);

        if ($session = session('search')) {
            $result
                ->where('name', 'LIKE', '%' . $session . '%')
                ->orWhere('description', 'LIKE', '%' . $session . '%');
        }

        // TODO WithCount for include COUNTS of relations
        return $result->withCount(['posts', 'replies'])->paginate(4);
    }
}
