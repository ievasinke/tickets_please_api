<?php

namespace App\Traits;

trait ApiResponses
{
	protected function ok($message, $data = [])
	{
		return $this->success($message, $data, 200);
	}

	protected function success($message, $data = [], $statusCode = 200)
	{
		return response()->json([
			'message' => $message,
			'data' => $data,
			'status' => $statusCode
		], $statusCode);
	}

	protected function error($errors = [], $statusCode = null)
	{
		if (is_string($errors)) {
			return response()->json([
				'message' => $errors,
				'status' => $statusCode
			], $statusCode);
		}

		return response()->json([
			'errors' => $errors,
		]);
	}

	protected function notAuthorized($message) {
		return $this->error([
			'status' => 403,
			'message' => $message,
		]);
	}
}
