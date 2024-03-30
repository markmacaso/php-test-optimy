<?php declare(strict_types = 1);

namespace OptimyTest\Providers;

use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;

/**
 * Error handler class
 */
class RouteProvider
{
    /**
     * @var
     */
    protected $routeDefinitionCallback;

    /**
     * Initialize the route provider
     */
    public function initialize($path)
    {
        $this->routeDefinitionCallback = function (RouteCollector $r) use ($path) {
            $routes = include($path);
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        };
        
    }

    public function getRouteInfo(Request $request)
    {
        $dispatcher = \FastRoute\simpleDispatcher($this->routeDefinitionCallback);
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        return $routeInfo;
    }
}