<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            if ($request->isMethod('POST') && $request->path() === 'files') {
                $messageBag = new MessageBag;
                $messageBag->add('file', 'Размер файла не должен превышать 3 МБ.');

                $errors = (new ViewErrorBag)->put('default', $messageBag);

                return response()->view('files.create', [
                    'errors' => $errors,
                ], 422);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The POST data is too large.',
                ], 413);
            }
        });
    })->create();
