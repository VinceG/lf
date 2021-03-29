<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Files\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Post;
use App\Repositories\FilesRepository;

class FilesController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->repository = new FilesRepository($request->route('post'));

            return $next($request);
        });

        $this->middleware('auth:api', ['only' => ['store']]);
    }

    public function index(Post $post)
    {
        return FileResource::collection($this->repository->paginate());
    }

    public function store(Post $post, FileRequest $request)
    {
        $file = $this->repository->create($request->validated());

        return (new FileResource($file))->response()->setStatusCode(201);
    }

    public function show(Post $post, File $file)
    {
        return new FileResource($file);
    }

    public function update(Post $post, File $file, FileRequest $request)
    {
        $this->authorize('update', $post, $file);

        $file = $this->repository->update($file, $request->validated());

        return new FileResource($file);
    }

    public function destroy(Post $post, File $file)
    {
        $this->authorize('delete', $post, $file);

        $this->repository->delete($file);

        return response()->noContent();
    }
}