<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function scopeOfPost($query, Post $post): Builder
    {
        return $query->whereHas('posts', function($query) use($post) {
            $query->where('post_id', $post->id);
        });
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, PostTagRelation::class, 'tag_id', 'post_id');
    }
}
