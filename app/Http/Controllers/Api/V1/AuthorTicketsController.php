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
	 * @response 200 {"data":[{"type":"ticket","id":6,"attributes":{"title":"PATCH Request works","status":"C","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T16:08:19.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/6"}},{"type":"ticket","id":29,"attributes":{"title":"repellat eligendi sequi","status":"H","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/29"}},{"type":"ticket","id":32,"attributes":{"title":"error repudiandae alias","status":"X","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/32"}},{"type":"ticket","id":37,"attributes":{"title":"quisquam alias earum","status":"A","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/37"}},{"type":"ticket","id":42,"attributes":{"title":"repellendus ipsam et","status":"H","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/42"}},{"type":"ticket","id":45,"attributes":{"title":"quia saepe cupiditate","status":"X","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/45"}},{"type":"ticket","id":48,"attributes":{"title":"vel ad quia","status":"X","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/48"}},{"type":"ticket","id":55,"attributes":{"title":"eos minima et","status":"C","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/55"}},{"type":"ticket","id":57,"attributes":{"title":"perferendis adipisci voluptates","status":"H","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/57"}},{"type":"ticket","id":69,"attributes":{"title":"itaque dolor quidem","status":"A","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/69"}},{"type":"ticket","id":81,"attributes":{"title":"non fuga sequi","status":"H","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/81"}},{"type":"ticket","id":84,"attributes":{"title":"a quia aliquam","status":"C","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/84"}},{"type":"ticket","id":96,"attributes":{"title":"magni ut commodi","status":"A","created_at":"2025-01-21T13:57:47.000000Z","updated_at":"2025-01-21T13:57:47.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/96"}},{"type":"ticket","id":101,"attributes":{"title":"Replace this title","status":"A","created_at":"2025-01-21T15:07:48.000000Z","updated_at":"2025-01-21T15:07:48.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/101"}},{"type":"ticket","id":102,"attributes":{"title":"a Ticket","status":"A","created_at":"2025-01-21T16:01:05.000000Z","updated_at":"2025-01-21T16:01:05.000000Z"},"relationships":{"author":{"data":{"type":"user","id":1},"links":{"self":"http:\/\/localhost\/api\/v1\/authors\/1"}}},"links":{"self":"http:\/\/localhost\/api\/v1\/tickets\/102"}}],"links":{"first":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=1","last":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=2","prev":null,"next":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=2"},"meta":{"current_page":1,"from":1,"last_page":2,"links":[{"url":null,"label":"&laquo; Previous","active":false},{"url":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=1","label":"1","active":true},{"url":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=2","label":"2","active":false},{"url":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets?page=2","label":"Next &raquo;","active":false}],"path":"http:\/\/localhost\/api\/v1\/authors\/1\/tickets","per_page":15,"to":15,"total":28}}
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
					['author' => 'user_id']
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
