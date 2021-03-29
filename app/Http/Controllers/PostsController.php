<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostsRepository;

class PostsController extends Controller
{
    protected $repository;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth:api', ['only' => ['store']]);
    }

    public function index()
    {
        return PostResource::collection($this->repository->paginate());
    }

    public function store(PostRequest $request)
    {
        $post = $this->repository->create(auth()->user(), $request->validated());

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    public function show(Post $post)
    {
        return new PostResource($post->fresh(['owner', 'file', 'tags']));
    }

    public function update(Post $post, PostRequest $request)
    {
        $this->authorize('update', $post);

        $post = $this->repository->update($post, $request->validated());

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->repository->delete($post);

        return response()->noContent();
    }
}