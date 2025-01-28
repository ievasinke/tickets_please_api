<?php

namespace App\Exceptions\Api\V1;

use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptions
{
	public static $handlers = [
		AuthenticationException::class => 'handleAuthentication',
		AuthorizationException::class => 'handleAuthorization',
		ModelNotFoundException::class => 'handleModelNotFound',
		NotFoundHttpException::class => 'handleModelNotFound',
		ValidationException::class => 'handleValidation'
	];

	use ApiResponses;

	public static function handleAuthentication(
		AuthenticationException $e,
		Request $request
		): JsonResponse
	{
		return response()->json([
			'errors' => [
				'type' => class_basename($e),
				'status' => 401,
				'message' => 'Unauthenticated.'
			],
		]);
	}

	public static function handleAuthorization(
		AuthenticationException $e,
		Request $request
		): JsonResponse
	{
		return response()->json([
			'errors' => [
				'type' => class_basename($e),
				'status' => 403,
				'message' => $e->getMessage()
			],
		]);
	}

	public static function handleModelNotFound(
		ModelNotFoundException|NotFoundHttpException $e, 
		Request $request
		): JsonResponse
	{
		return response()->json([
			'errors' => [
				'type' => class_basename($e),
				'status' => 404,
				'message' => 'The resource cannot be found.'
			],
		]);
	}

	public static function handleValidation(
		ValidationException $e, 
		Request $request
		): JsonResponse
	{
		foreach ($e->errors() as $key => $value) {
			foreach ($value as $message) {
				$errors[] = [
					'type' => class_basename($e),
					'status' => 422,
					'message' => $message,
					'source' => $key
				];
			}
		}
		return response()->json([
			'errors' => $errors,
		]);
	}
}
