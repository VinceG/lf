<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Post;

class FilesRepository
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function paginate()
    {
        return File::ofPost($this->post)->paginate();
    }

    public function create(array $attributes)
    {
        return File::create($attributes + ['post_id' => $this->post->id]);
    }

    public function update(File $file, array $attributes)
    {
        $file->update($attributes);

        return $file;
    }

    public function delete(File $file)
    {
        return $file->delete();
    }
}
