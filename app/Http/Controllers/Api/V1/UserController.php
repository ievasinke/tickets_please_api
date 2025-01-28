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

		return $this->notAuthorized('You are not authorized to create this resource');
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
	public function update(
		UpdateUserRequest $request,
		User $user
	) {
		// PATCH
		//policy
		if ($this->isAble('update', $user)) {
			$user->update($request->mappedAttributes());

			return new UserResource($user);
		}

		return $this->notAuthorized('You are not authorized to update this resource');
	}

	/**
	 * Replace the specified resource in storage.
	 */
	public function replace(
		ReplaceUserRequest $request,
		User $user
	) {
		// PUT
		//policy
		if ($this->isAble('replace', $user)) {
			$user->update($request->mappedAttributes());

			return new UserResource($user);
		}

		return $this->notAuthorized('You are not authorized to update this resource');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(User $user)
	{
		//policy
		if ($this->isAble('delete', $user)) {
			$user->delete();

			return $this->ok('User successfully deleted');
		}

		return $this->notAuthorized('You are not authorized to delete this resource');
	}
}
