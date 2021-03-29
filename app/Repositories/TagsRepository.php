<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Tag;

class TagsRepository
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    
    public function paginate()
    {
        return Tag::ofPost($this->post)->paginate();
    }

    public function create(array $attributes)
    {
        $tag = Tag::updateOrCreate($attributes);

        $this->post->tags()->syncWithoutDetaching([$tag->id]);

        return $tag;
    }

    public function update(Tag $tag, array $attributes)
    {
        $tag->update($attributes);

        return $tag;
    }

    public function delete(Tag $tag)
    {
        return $this->post->tags()->detach([$tag->id]);
    }
}
