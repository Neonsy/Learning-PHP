<?php

declare(strict_types=1);

namespace MVCSpace\Core\Routing;

use Error;
use MVCSpace\Core\App;
use MVCSpace\Core\Enum\HTTP\MethodAction;
use MVCSpace\Core\Enum\Path;
use MVCSpace\Core\Exceptions\DuplicateRouteException;
use MVCSpace\Core\Exceptions\InvalidControllerActionException;
use MVCSpace\Core\Exceptions\InvalidControllerException;
use MVCSpace\Core\Exceptions\InvalidMiddlewareTypeException;
use MVCSpace\Core\Exceptions\NoRoutesForRequestMethodException;
use MVCSpace\Core\Exceptions\RouteNotFoundException;
use MVCSpace\Core\Exceptions\ViewNotFoundException;
use MVCSpace\Core\HTTP\Request;
use MVCSpace\Core\HTTP\Response;
use MVCSpace\Core\Interface\Controller\IDelete;
use MVCSpace\Core\Interface\Controller\IGet;
use MVCSpace\Core\Interface\Controller\IPost;
use MVCSpace\Core\Interface\Controller\IPut;

class Router
{
    /**
     * @var array $routes This is the routeMap for the entire application.
     */
    private array $routes;
    /**
     * @var array $lastRoute Holds the last registered route, to simplify the process of adding middleware to a specific route.
     */
    private array $lastRoute;

    /**
     * This method delegates the registration to the internal route registration handler.
     * @param string $path
     * @param string $controller
     * @return Router For chaining
     * @throws DuplicateRouteException
     * @see self::addRoute()
     */
    public function get(string $path, string $controller): self
    {
        $this->addRoute($path, $controller, MethodAction::GET);
        return $this;
    }

    /**
     * This method delegates the registration to the internal route registration handler.
     * @param string $path
     * @param string $controller
     * @return Router For chaining
     * @throws DuplicateRouteException
     * @see self::addRoute()
     */
    public function post(string $path, string $controller): self
    {
        $this->addRoute($path, $controller, MethodAction::POST);
        return $this;
    }

    /**
     * This method delegates the registration to the internal route registration handler.
     * @param string $path
     * @param string $controller
     * @return Router For chaining
     * @throws DuplicateRouteException
     * @see self::addRoute()
     */
    public function put(string $path, string $controller): self
    {
        $this->addRoute($path, $controller, MethodAction::PUT);
        return $this;
    }

    /**
     * This method delegates the registration to the internal route registration handler.
     * @param string $path
     * @param string $controller
     * @return Router For chaining
     * @throws DuplicateRouteException
     * @see self::addRoute()
     */
    public function delete(string $path, string $controller): self
    {
        $this->addRoute($path, $controller, MethodAction::DELETE);
        return $this;
    }

    /**
     * This is the actual method, that registers a route to the apps router.
     * @param string $path
     * @param string $controller
     * @param MethodAction $methodAction
     * @return void
     * @throws DuplicateRouteException
     */
    private function addRoute(string $path, string $controller, MethodAction $methodAction): void
    {
        $method = $methodAction->name;
        if (!isset($this->routes[$method][$path])) {
            $action = $methodAction->value;

            $this->routes[$method][$path] = ['Controller' => $controller, 'Action' => $action, 'Middlewares' => []];
            $this->lastRoute[$method] = $path;
        } else {
            throw new DuplicateRouteException($method, $path);
        }
    }

    /**
     * Adds the specified middleware to the route.
     * @param callable $middleware
     * @return $this For chaining
     */
    public function middleware(callable $middleware): self
    {
        $key = key($this->lastRoute);
        $value = $this->lastRoute[$key];

        $this->routes[$key][$value]['Middlewares'][] = $middleware;
        return $this;
    }

    /**
     * Validates the route, controller and action.
     *
     * If validation passes, it dispatches to the action within the specified controller.
     * @param Request $request
     * @param Response $response
     * @return void
     * @throws NoRoutesForRequestMethodException
     * @throws RouteNotFoundException
     * @throws InvalidControllerException
     * @throws InvalidControllerActionException
     * @throws ViewNotFoundException
     */
    public function dispatch(Request $request, Response $response): void
    {
        // 1. Does the request method have any routes registered to it?
        $method = $request->getMethodAction()->name;

        if (!isset($this->routes[$method])) {
            throw new NoRoutesForRequestMethodException($method);
        }

        // 2. Seeing that the request method has routes registered, is the requested route valid?
        $requestRoute = $request->getPath();

        $routeData = $this->validateRequestRoute($this->routes[$method], $requestRoute);

        // 3. Seeing that a match was found, does the controller exist?
        $controller = $this->verifyController($routeData['Controller']);

        // 4. Now that we have the controller, we must check whether it has the action we want to call
        $action = $routeData['Action'];

        if (!method_exists($controller, $action)) {
            // Sidenote: This will only become relevant when we need more than one request method for a controller
            throw new InvalidControllerActionException($controller, $action);
        }

        // 5. Everything seems to work, so let's call the controllers action method

        try {
            App::middlewareRunner($routeData
            ['Middlewares'],
                $request,
                $response,
                function () use ($controller, $action, $request, $response, $routeData) {
                    $controller->$action($request, $response, $routeData['Params']);
                });
        } catch (InvalidMiddlewareTypeException $e) {
            $response->specifyContent($e->getMessage())
                ->send();
        }
    }

    /**
     * Attempts to find the requested route amongst the routes in the given http method and get the data if it exists.
     * @param array $routes
     * @param string $requestRoute
     * @return array
     * @throws RouteNotFoundException
     */
    private function validateRequestRoute(array $routes, string $requestRoute): array
    {
        // Get each route segment seperated by /
        $requestSegments = explode('/', trim($requestRoute, '/'));

        foreach ($routes as $route => $routeData) {
            // Do the same for the current route check
            $routeSegments = explode('/', trim($route, '/'));

            // They need to have the same amount of segments to be a possible match
            if (count($routeSegments) === count($requestSegments)) {
                $matchFound = true;
                $params = [];

                foreach ($routeSegments as $index => $segment) {
                    if (strlen($segment) > 0 && $segment[0] === ':') {
                        // If the current route segment starts with ':', it's a parameter.
                        $params[ltrim($segment, ':')] = $requestSegments[$index];

                        // Is the current segment the same?
                    } else if (strtolower($segment) !== strtolower($requestSegments[$index])) {
                        $matchFound = false;
                        break;
                    }
                }

                if ($matchFound) {
                    return [...$routeData, 'Params' => $params];
                }
            }
        }
        throw new RouteNotFoundException($requestRoute);
    }

    /**
     * Verifies if the required controller exists.
     * @param string $controller
     * @return IGet|IPost|IPut|IDelete
     * @throws InvalidControllerException
     */
    private function verifyController(string $controller): IGet|IPost|IPut|IDelete
    {
        // Namespace in this project only consists of one word
        $globalNamespace = explode('\\', __NAMESPACE__)[0];

        // Controller Location Namespace
        $currentNamespace = str_replace(realpath(Path::SRC->value), '', realpath(Path::CONTROLLER->value));

        $fqn = "$globalNamespace$currentNamespace\\$controller";
        $fqn = str_replace('/', '\\', $fqn); // Namespaces need '\'

        if (class_exists($fqn)) {
            try {
                return new $fqn();
            } catch (Error) {
                App::dump("The controller '$controller' does exist, but is missing one or more Interfaces:");
                App::dump(IGet::class, false);
                App::dump(IPost::class, false);
                App::dump(IPut::class, false);
                App::dump(IDelete::class, false, true);
            }
        }
        throw new InvalidControllerException($controller);
    }
}