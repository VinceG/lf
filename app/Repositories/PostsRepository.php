<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;

class PostsRepository
{
    public function paginate()
    {
        return Post::with(['owner', 'file', 'tags'])->paginate();
    }

    public function create(User $user, array $attributes)
    {
        // create or update post by the uuid
        $post = Post::updateOrCreate(['id' => $attributes['id']], $attributes);

        // Associate tags
        // not creating since the array objects come with id
        $post->tags()->syncWithoutDetaching(collect($attributes['tags'] ?? [])->pluck('id')->all());

        return $post->fresh(['owner', 'file', 'tags']);
    }

    public function update(Post $post, array $attributes)
    {
        $post->update($attributes);

        return $post;
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }
}
