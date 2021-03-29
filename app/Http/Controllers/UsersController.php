<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth:api', ['only' => ['update']]);
    }

    public function index()
    {
        return UserResource::collection($this->repository->paginate());
    }

    public function store(UserRequest $request)
    {
        $user = $this->repository->create($request->validated());

        return (new UserResource($user, true))->response()->setStatusCode(201);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, UserRequest $request)
    {
        $user = $this->repository->update($user, $request->validated());

        return new UserResource($user, true);
    }
}