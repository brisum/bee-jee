<?php

namespace App\Utils;

use App\Controller\MainController;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteService
{
    protected $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();

        $route = new Route('/', ['_controller' => [MainController::class, 'indexAction']]);
        $this->routes->add('main', $route);
    }

    public function match()
    {
        $context = new RequestContext('/');

        $matcher = new UrlMatcher($this->routes, $context);
        return $matcher->match($_SERVER['REQUEST_URI']);
    }
}
