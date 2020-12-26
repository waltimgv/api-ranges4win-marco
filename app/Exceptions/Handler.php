<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        switch ($request->wantsJson()) {
            case $exception instanceof ModelNotFoundException:
                return $this->handleModelNotFound();
            case $exception instanceof ValidationException:
                return $this->handleValidation($exception);
            case $exception instanceof Exception:
                return $this->handleException($exception);
        }

        return parent::render($request, $exception);
    }

    private function handleModelNotFound()
    {
        return response()->json(['message' => 'Not Found!'], 404);
    }

    private function handleValidation(ValidationException $exception)
    {
        return response()->json([
            'message' => $exception->getMessage(),
            'errors' => $exception->errors()
        ], $exception->status);
    }

    private function handleException(Exception $exception)
    {
        return response()->json([
            'message' => 'Internal Server Error!',
            'error' => $exception->getMessage()
        ], 500);
    }
}
