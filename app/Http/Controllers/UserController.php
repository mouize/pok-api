<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(protected UserRepository $repository)
    {
        $this->repository->withHttpRequest();
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this
            ->repository
            ->paginate();

        return UserResource::collection($users);
    }

    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request): JsonResource
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = $this->repository->create($validatedData);

        $user->createToken('auth_token')->plainTextToken;

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResource
    {
        $validatedData = $request->validated();
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $this->repository->update($user->id, $validatedData);

        return new UserResource($user->fresh());
    }

    public function destroy(User $user): Response
    {
        $this->repository->delete($user->id);

        return response()->noContent();
    }
}
