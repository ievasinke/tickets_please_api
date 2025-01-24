<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
	use ApiResponses;

	protected $policyClass;

	public function __construct()
	{
		Gate::guessPolicyNamesUsing( 
			fn() => $this->policyClass 
		);
	}

	public function include(string $relationship): bool
	{
		$param = request()->get('include');

		if (!isset($param)) {
			return false;
		}

		$includeValues = explode(',', strtolower($param));

		return in_array(strtolower($relationship), $includeValues);
	}

	public function isAble(string $ability, mixed $targetModel) {
		try {
			Gate::authorize($ability, [$targetModel, $this->policyClass]);
			return true;
		} catch (AuthenticationException $exception) {
			return false;
		}
	}
}
