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
	 * Store a newly created resource in storage.
	 */
	public function store(StoreTicketRequest $request, $authorId)
	{
		//policy
		if ($this->isAble('store', Ticket::class)) {
			return new TicketResource(Ticket::create($request->mappedAttributes([
				'author' => 'user_id',
			])));
		}

		return $this->error('You are not authorized to create this resource', 403);
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

			if ($this->isAble('replace', $ticket)) {
				$ticket->update($request->mappedAttributes());

				return new TicketResource($ticket);
			}

			return $this->error('You are not authorized to update this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		}
	}

	public function update(UpdateTicketRequest $request, $authorId, $ticketId)
	{
		// PATCH
		try {
			$ticket = Ticket::where('id', $ticketId)
				->where('user_id', $authorId)
				->firstOrFail();

			if ($this->isAble('update', $ticket)) {
				$ticket->update($request->mappedAttributes());

				return new TicketResource($ticket);
			}

			return $this->error('You are not authorized to update this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
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

			if ($this->isAble('delete', $ticket)) {
				$ticket->delete();

				return $this->ok('Ticket successfully deleted');
			}

			return $this->error('You are not authorized to delete this resource', 403);
		} catch (ModelNotFoundException $exception) {
			return $this->error('Ticket cannot be found', 404);
		}
	}
}
