<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'post_id'
    ];

    public function scopeOfPost($query, Post $post): Builder
    {
        return $query->where('post_id', $post->id);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
