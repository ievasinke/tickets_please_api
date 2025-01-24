<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Models\User;
use App\Policies\V1\UserPolicy;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends ApiController
{
	protected $policyClass = UserPolicy::class;
	/**
	 * Display a listing of the resource.
	 */
	public function index(AuthorFilter $filters)
	{
		return UserResource::collection(
			User::filter($filters)
				->paginate()
		);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreUserRequest $request)
	{
		//policy
		if ($this->isAble('store', User::class)) {
			return new UserResource(User::create($request->mappedAttributes()));
		}

		return $this->error('You are not authorized to create this resource', 403);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(User $user)
	{
		if ($this->include('tickets')) {
			return new UserResource($user->load('tickets'));
		}

		return new UserResource($user);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateUserRequest $request, $userId)
	{
		// PATCH
		try {
			$user = User::findOrFail($userId);

			//policy
			if ($this->isAble('update', $user)) {
				$user->update($request->mappedAttributes());

				return new UserResource($user);
			}

			return $this->error('You are not authorized to update this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('User cannot be found', 404);
		}
	}

	/**
	 * Replace the specified resource in storage.
	 */
	public function replace(ReplaceUserRequest $request, $userId)
	{
		// PUT
		try {
			$user = User::findOrFail($userId);

			//policy
			if ($this->isAble('replace', $user)) {
				$user->update($request->mappedAttributes());

				return new UserResource($user);
			}

			return $this->error('You are not authorized to update this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('User cannot be found', 404);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($userId)
	{
		try {
			$user = User::findOrFail($userId);

			//policy
			if ($this->isAble('delete', $user)) {
				$user->delete();

				return $this->ok('User successfully deleted');
			}

			return $this->error('You are not authorized to delete this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('User cannot be found', 404);
		}
	}
}
