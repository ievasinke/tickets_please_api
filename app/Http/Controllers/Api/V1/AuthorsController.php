<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Http\Filters\V1\AuthorFilter;

class AuthorsController extends ApiController
{
	/**
	 * Get all authors
	 * 
	 * Retrieves all users that have created tickets.
	 * 
	 * @group Showing Authors
	 */
	public function index(AuthorFilter $filters)
	{
		return UserResource::collection(
			User::select('users.*')
				->join('tickets', 'users.id', '=', 'tickets.user_id')
				->filter($filters)
				->distinct()
				->paginate()
		);
	}

	/**
	 * Get a specific author
	 * 
	 * Display an individual user.
	 * 
	 * @group Showing Authors
	 */
	public function show(User $author)
	{
		if ($this->include('tickets')) {
			return new UserResource($author->load('tickets'));
		}

		return new UserResource($author);
	}
}
