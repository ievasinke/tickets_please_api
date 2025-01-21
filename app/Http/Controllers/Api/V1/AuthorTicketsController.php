<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;


class AuthorTicketsController extends ApiController
{
	protected $policyClass = TicketPolicy::class;

	public function index($authorId, TicketFilter $filters)
	{
		return TicketResource::collection(
			Ticket::where('user_id', $authorId)
				->filter($filters)
				->paginate()
		);
	}
	/**
	 * Replace the specified resource in storage.
	 */
	public function replace(ReplaceTicketRequest $request, $authorId, $ticketId)
	{
		// PUT
		try {
			$ticket = Ticket::where('id', $ticketId)
				->where('user_id', $authorId)
				->firstOrFail();

			$this->isAble('replace', $ticket);

			$ticket->update($request->mappedAttributes());

			return new TicketResource($ticket);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		} catch (AuthorizationException $exception) {
			return $this->error('You are not authorized to update this resource', 403);
		}
	}

	public function update(UpdateTicketRequest $request, $authorId, $ticketId)
	{
		// PATCH
		try {
			$ticket = Ticket::where('id', $ticketId)
				->where('user_id', $authorId)
				->firstOrFail();

			$this->isAble('update', $ticket);

			$ticket->update($request->mappedAttributes());

			return new TicketResource($ticket);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		} catch (AuthorizationException $exception) {
			return $this->error('You are not authorized to update this resource', 403);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreTicketRequest $request, $authorId)
	{
		try {
			//policy
			$this->isAble('store', Ticket::class);

			return new TicketResource(Ticket::create($request->mappedAttributes([
				'author' => 'user_id',
			])));
		} catch (AuthorizationException $exception) {
			return $this->error('You are not authorized to create this resource', 403);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($authorId, $ticketId)
	{
		try {
			$ticket = Ticket::where('id', $ticketId)
				->where('user_id', $authorId)
				->firstOrFail();

			$this->isAble('delete', $ticket);

			$ticket->delete();

			return $this->ok('Ticket successfully deleted');
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		} catch (AuthorizationException $exception) {
			return $this->error('You are not authorized to delete this resource', 403);
		}
	}
}
