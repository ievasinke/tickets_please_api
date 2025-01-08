<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Models\Ticket;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends ApiController
{
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
			$ticket = Ticket::findOrFail($ticketId);

			if ($ticket->user_id == $authorId) {
	
				$ticket->update($request->mappedAttributes());
	
				return new TicketResource($ticket);
			}
// TODO: ticket doesn't belong to user

		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		}
	}

	public function update(UpdateTicketRequest $request, $authorId, $ticketId)
	{
		// PATCH
		try {
			$ticket = Ticket::findOrFail($ticketId);

			if ($ticket->user_id == $authorId) {
	
				$ticket->update($request->mappedAttributes());
	
				return new TicketResource($ticket);
			}
// TODO: ticket doesn't belong to user

		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store($authorId, StoreTicketRequest $request)
	{

		return new TicketResource(Ticket::create($request->mappedAttributes()));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($authorId, $ticketId)
	{
		try {
			$ticket = Ticket::findOrFail($ticketId);

			if ($ticket->user_id == $authorId) {
				$ticket->delete();

				return $this->ok('Ticket successfully deleted');
			}

			return $this->error('Ticket cannot be found', 404);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		}
	}
}
