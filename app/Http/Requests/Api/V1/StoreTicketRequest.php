<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\V1\BaseTicketRequest;
use App\Permissions\V1\Abilities;
use Illuminate\Support\Facades\Auth;

class StoreTicketRequest extends BaseTicketRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		$isTicketsController = $this->routeIs('tickets.store');
		$authorIdAttribute = $isTicketsController ? 'data.relationships.author.data.id' : 'author';
		$user = Auth::user();
		$authorRule = 'required|integer|exists:users,id';

		$rules = [
			'data' => 'required|array',
			'data.attributes' => 'required|array',
			'data.attributes.title' => 'required|string',
			'data.attributes.description' => 'required|string',
			'data.attributes.status' => 'required|string|in:A,C,H,X'
		];

		if ($isTicketsController) {
			$rules['data.relationships'] = 'required|array';
			$rules['data.relationships.author'] = 'required|array';
			$rules['data.relationships.author.data'] = 'required|array';
		}

		$rules[$authorIdAttribute] = $authorRule . '|size:' . $user->id;

		if ($user->tokenCan(Abilities::CreateTicket)) {
			$rules[$authorIdAttribute] = $authorRule;
		}
		return $rules;
	}

	protected function prepareForValidation()
	{
		if ($this->routeIs('authors.tickets.store')) {
			$this->merge([
				'author' => $this->route('author'),
			]);
		}
	}

	public function bodyParameters(): array
	{
		$documentation = [
			'data.attributes.title' => [
				'description' => "The ticket's title (method)",
				'example' => null
			],
			'data.attributes.description' => [
				'description' => "The ticket's description",
				'example' => null
			],
			'data.attributes.status' => [
				'description' => "The ticket's title status",
				'example' => null
			]
		];

		if ($this->routeIs('tickets.store')) {
			$documentation['data.relationships.author.data.id'] = [
				'description' => "The author assign to the ticket",
				'example' => null
			];
		} else {
			$documentation['author'] = [
				'description' => "The author assign to the ticket",
				'example' => null
			];
		}

		return $documentation;
	}
}
