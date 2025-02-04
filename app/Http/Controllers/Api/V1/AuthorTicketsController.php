<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;

class AuthorTicketsController extends ApiController
{
	protected $policyClass = TicketPolicy::class;

	/**
	 * Get all tickets
	 * 
	 * Retrieves all tickets created by a specific user.
	 * 
	 * @group Managing Tickets by Author
	 * 
	 * @urlParam authorId integer required The author's ID. No-example
	 * 
	 * @response 200 { //TODO: Add response body }
	 * 
	 * @queryParam sort string Data field(s) to sort by. Separate multiple fields with commas. Denote descending sort with a minus sign. Example: sort=name
	 * @queryParam filter[name] Filter by name. Wildcards are supported. No-example
	 * @queryParam filter[email] Filter by email. Wildcards are supported. No-example
	 */
	public function index(
		User $author,
		TicketFilter $filters
	) {
		return TicketResource::collection(
			Ticket::where('user_id', $author->id)
				->filter($filters)
				->paginate()
		);
	}

	/**
	 * Create a ticket
	 * 
	 * Creates a ticket for a specific user.
	 * 
	 * @group Managing Tickets by Author
	 * 
	 * @urlParam authorId integer required The author's ID. No-example
	 * 
	 */
	public function store(
		User $author,
		StoreTicketRequest $request
	) {
		//policy
		if ($this->isAble('store', Ticket::class)) {
			return new TicketResource(
				Ticket::create($request->mappedAttributes(
					['author_id' => $author->id]
				))
			);
		}

		return $this->notAuthorized('You are not authorized to create this resource');
	}

	/**
	 * Replace an author's ticket
	 * 
	 * Replaces a ticket for a specific user.
	 * 
	 * @group Managing Tickets by Author
	 * 
	 * @urlParam authorId integer required The author's ID. No-example
	 * @urlParam ticketId integer required The ticket's ID. No-example
	 * 
	 * @response {"data":{"type":"ticket","id":9,"attributes":{"title":"New title","description":"Lore ipsum","status":"C","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-30T13:16:42.000000Z"},"relationships":{"author":{"data":{"type":"user","id":4},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/4"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/9"}}}
	 */
	public function replace(
		ReplaceTicketRequest $request,
		User $author,
		Ticket $ticket
	) {
		// PUT
		if ($this->isAble('replace', $ticket)) {
			$ticket->update($request->mappedAttributes());

			return new TicketResource($ticket);
		}

		return $this->notAuthorized('You are not authorized to update this resource');
	}

	/**
	 * Update an author's ticket
	 * 
	 * Update an author's ticket.
	 * 
	 * @group Managing Tickets by Author
	 * 
	 * @urlParam authorId integer required The author's ID. No-example
	 * @urlParam ticketId integer required The ticket's ID. No-example
	 * 
	 */
	public function update(
		UpdateTicketRequest $request,
		User $author,
		Ticket $ticket
	) {
		// PATCH
		if ($this->isAble('update', $ticket)) {
			$ticket->update($request->mappedAttributes());

			return new TicketResource($ticket);
		}

		return $this->notAuthorized('You are not authorized to update this resource');
	}

	/**
	 * Delete an author's ticket
	 * 
	 * Delete an author's ticket.
	 * 
	 * @group Managing Tickets by Author
	 * 
	 * @urlParam authorId integer required The author's ID. No-example
	 * @urlParam ticketId integer required The ticket's ID. No-example
	 * 
	 * @response {}
	 */
	public function destroy(
		User $author,
		Ticket $ticket
	) {
		if ($this->isAble('delete', $ticket)) {
			$ticket->delete();

			return $this->ok('Ticket successfully deleted');
		}

		return $this->notAuthorized('You are not authorized to delete this resource');
	}
}
