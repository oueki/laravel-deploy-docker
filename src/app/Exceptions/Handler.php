<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use LaravelJsonApi\Core\Exceptions\JsonApiException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        BusinessException::class,
        JsonApiException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(
            \LaravelJsonApi\Exceptions\ExceptionParser::make()->renderable()
        );
    }


    public function render($request, Throwable $e)
    {
        if ($e instanceof BusinessException)
        {
            if($request->ajax())
            {
                $json = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];

                return response()->json($json, 400);
            }
            else
            {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'error' => $e->getMessage()]);
            }
        }

        // Стандартный показ ошибки
        // такой как страница 404
        return parent::render($request, $e);
    }

}
