<?php

use App\Exceptions\Api\V1\ApiExceptions;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		api: __DIR__ . '/../routes/api.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		//
	})
	->withExceptions(function (Exceptions $exceptions) {
		$exceptions->render(function (Throwable $e, Request $request) {
			$className = get_class($e);
			$handlers = ApiExceptions::$handlers;

			if (array_key_exists($className, $handlers)) {
				$method = $handlers[$className];
				return ApiExceptions::$method($e, $request);
			}

			return response()->json([
				'error' => [
					'type' => class_basename($e),
					'status' => intval($e->getCode()),
					'message' => $e->getMessage(),
					'LOG' => '..source.. Line: ' . $e->getLine() . ': ' . $e->getFile()
				]
			]);
		});
	})->create();
