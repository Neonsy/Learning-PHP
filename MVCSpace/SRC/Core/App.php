<?php

declare(strict_types=1);

namespace MVCSpace\Core;

use MVCSpace\Core\Enum\HTTP\ResponseCode;
use MVCSpace\Core\Enum\Path;
use MVCSpace\Core\Exceptions\InvalidControllerActionException;
use MVCSpace\Core\Exceptions\InvalidControllerException;
use MVCSpace\Core\Exceptions\InvalidMiddlewareTypeException;
use MVCSpace\Core\Exceptions\NoRoutesForRequestMethodException;
use MVCSpace\Core\Exceptions\RouteNotFoundException;
use MVCSpace\Core\Exceptions\ViewNotFoundException;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\IMiddleware;
use MVCSpace\Core\Routing\Router;
use MVCSpace\Core\Routing\Routes;
use MVCSpace\Core\Service\Builder;

class App
{
    /**
     * @var Request $request Holds and manages the relevant data of the incoming HTTP request.
     */
    private Request $request;
    /**
     * @var Response $response Holds and manages the relevant information for the response to send back to the client.
     */
    private Response $response;
    /**
     * @var Router $router The router of the application.
     */
    private Router $router;
    /**
     * @var array $middlewares Holds the application global middlewares, running on every request.
     */
    private array $middlewares;

    public function __construct(array $middlewares = [])
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
        $this->middlewares = $middlewares;
    }

    /**
     * The entry point of the application.
     * @return void
     */
    public function run(): void
    {
        try {
            Builder::build(); // Create build blueprint function for services
        } catch (Exceptions\DuplicateServiceException $e) {
            $this->response->specifyContent($e->getMessage())
                ->send();
        }

        Routes::register($this->router);

        try {
            self::middlewareRunner(
                $this->middlewares,
                $this->request,
                $this->response,
                function () {
                    try {
                        $this->router->dispatch($this->request, $this->response);
                    } catch
                    (NoRoutesForRequestMethodException|
                    InvalidControllerException|
                    InvalidControllerActionException|
                    ViewNotFoundException $e) {
                        $this->response->specifyContent($e->getMessage())
                            ->send();
                    } catch (RouteNotFoundException $e) {
                        $this->response->specifyContent($e->getMessage())
                            ->responseCode(ResponseCode::NOT_FOUND)
                            ->send();
                    }
                });
        } catch (InvalidMiddlewareTypeException $e) {
            $this->response->specifyContent($e->getMessage())
                ->send();
        }

        $this->response->responseCode(ResponseCode::OK)->send();
    }

    /**
     * A var_dump() wrapper, that shows who called this function and conditionally exits.
     *
     * Less effective with XDebug.
     * @param mixed|null $value
     * @param bool $showCallerInfo
     * @param bool $exit
     * @return void
     */
    public static function dump(mixed $value = null, bool $showCallerInfo = true, bool $exit = false): void
    {
        if ($showCallerInfo) {
            $caller = debug_backtrace()[0];

            $filePath = $caller['file'];
            $lineNumber = $caller['line'];

            $file = str_replace(realpath(Path::SRC->value), '', $filePath);

            echo "File '$file' called on line '$lineNumber'";
        }

        if (!is_null($value)) {
            echo '<pre>';
            var_dump($value);
            echo '</pre>';
        }

        if ($exit) {
            exit('Script stopped execution due to debugging purposes...');
        }
    }

    /**
     * Puts the view file into a string buffer to be displayed later.
     * @param string $viewFile
     * @param array $params
     * @return string
     * @throws ViewNotFoundException
     */
    public static function render(string $viewFile, array $params = []): string
    {
        extract($params);

        $filePath = realpath(Path::VIEW->value) . "\\$viewFile.view.php";


        if (file_exists($filePath)) {
            ob_start();
            require_once $filePath;
            return ob_get_clean();
        }
        throw new ViewNotFoundException($viewFile);
    }

    /**
     * Attempts to build up and run the middlewares provided as arguments.
     * @param array $middlewares
     * @param Request $request
     * @param Response $response
     * @param callable $core The function to be executed after the stack is done
     * @return void
     * @throws InvalidMiddlewareTypeException
     */
    public static function middlewareRunner(array $middlewares, Request $request, Response $response, callable $core): void
    {
        // Check if all "middlewares" are actually implementing the interface
        array_walk($middlewares, function ($middleware) {
            if (!$middleware instanceof IMiddleware) {
                throw new InvalidMiddlewareTypeException($middleware);
            }
        });

        // Create a stack of middleware functions
        $stack = array_reduce(array_reverse($middlewares), function ($stack, $middleware) {
            // For each middleware, return a new function that takes a request and response
            return function ($request, $response) use ($middleware, $stack) {
                // Call the current middleware, passing the request, response, and the next middleware
                return $middleware($request, $response, $stack);
            };
        }, $core); // Core application logic as the last item in the stack

        // Execute the middleware stack
        $stack($request, $response);
    }
}