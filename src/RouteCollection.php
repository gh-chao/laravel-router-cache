<?php

namespace Lilocon\RouterCache;

/**
 * Class RouteCollection
 * @package Lilocon\RouterCache
 */
class RouteCollection extends \Illuminate\Routing\RouteCollection
{

    /**
     * <5.4
     * Determine if a route in the array matches the request.
     *
     * @param  array  $routes
     * @param  \Illuminate\http\Request  $request
     * @param  bool  $includingMethod
     * @return \Illuminate\Routing\Route|null
     */
    protected function check(array $routes, $request, $includingMethod = true)
    {
        return $this->matchAgainstRoutes($routes, $request, $includingMethod);
    }

    /**
     * >=5.4
     * Determine if a route in the array matches the request.
     *
     * @param  array  $routes
     * @param  \Illuminate\http\Request  $request
     * @param  bool  $includingMethod
     * @return \Illuminate\Routing\Route|null
     */
    protected function matchAgainstRoutes(array $routes, $request, $includingMethod = true)
    {
        $key = sprintf('lilocon_route_%s_%s', $request->getMethod(), $request->path());

        if ($routeName = apcu_fetch($key)) {
            return $this->getByName($routeName);
        }

        if (method_exists($this, 'check')) {
            $route = parent::check($routes, $request, $includingMethod);
        } else {
            $route = parent::matchAgainstRoutes($routes, $request, $includingMethod);
        }

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
