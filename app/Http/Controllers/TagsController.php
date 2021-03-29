<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\TagsRepository;

class TagsController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->repository = new TagsRepository($request->route('post'));

            return $next($request);
        });

        $this->middleware('auth:api', ['only' => ['store']]);
    }

    public function index(Post $post)
    {
        return TagResource::collection($this->repository->paginate());
    }

    public function store(Post $post, TagRequest $request)
    {
        $tag = $this->repository->create($request->validated());

        return (new TagResource($tag))->response()->setStatusCode(201);
    }

    public function show(Post $post, Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(Post $post, Tag $tag, TagRequest $request)
    {
        $this->authorize('update', [$tag, $post]);

        $tag = $this->repository->update($tag, $request->validated());

        return new TagResource($tag);
    }

    public function destroy(Post $post, Tag $tag)
    {
        $this->authorize('delete', [$tag, $post]);

        $this->repository->delete($tag);

        return response()->noContent();
    }
}