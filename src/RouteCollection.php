<?php

namespace Lilocon\RouterCache;

/**
 * Class RouteCollection
 * @package Lilocon\RouterCache
 */
class RouteCollection extends \Illuminate\Routing\RouteCollection
{
    protected function matchAgainstRoutes(array $routes, $request, $includingMethod = true)
    {
        $key = sprintf('lilocon_route_%s_%s', $request->getMethod(), $request->path());

        if ($routeName = apcu_fetch($key)) {
            return $this->getByName($routeName);
        }

        $route = parent::matchAgainstRoutes($routes, $request, $includingMethod);

        if (
            $route
            && ($routeName = $route->getName())
            && (false !== array_search('router.cache', $route->middleware()))
        ) {
            apcu_add($key, $routeName);
        }

        return $route;
    }
}