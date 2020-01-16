<?php

namespace App\Utils;

use App\Controller\MainController;
use App\Controller\TaskController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteService
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var
     */
    protected $context;

    public function __construct()
    {
        $this->context = new RequestContext();
        $this->routes = new RouteCollection();

        $this->context->fromRequest(Request::createFromGlobals());

        $this->routes->add(
            MainController::INDEX_ACTION_NAME,
            new Route(
                '/',
                ['_controller' => [MainController::class, 'indexAction']],
                [], // requirements
                [], // $options
                '', // $host
                [], // $schemes,
                ['GET']
            )
        );
        $this->routes->add(
            MainController::PAGE_ACTION_NAME,
            new Route(
                '/page/{page}/',
                [
                    '_controller' => [MainController::class, 'indexAction'],
                    ['page' => '[0-9]+'], // requirements
                    [], // $options
                    '', // $host
                    [], // $schemes,
                    ['GET']
                ]
            )
        );

        $this->routes->add(
            TaskController::NEW_ACTION_NAME,
            new Route(
                '/task/new',
                ['_controller' => [TaskController::class, 'newAction']],
                [], // requirements
                [], // $options
                '', // $host
                [], // $schemes,
                ['GET', 'POST']
            )
        );
        $this->routes->add(
            TaskController::CREATE_SUCCESS_ACTION_NAME,
            new Route(
                '/task/create-success',
                ['_controller' => [TaskController::class, 'createSuccessAction']],
                [], // requirements
                [], // $options
                '', // $host
                [], // $schemes,
                ['GET']
            )
        );
    }

    public function match()
    {
        $matcher = new UrlMatcher($this->routes, $this->context);
        return $matcher->match($this->context->getPathInfo());
    }

    public function generate($name, array $parameters = [])
    {
        $generator = new UrlGenerator($this->routes, $this->context);
        return $generator->generate($name, $parameters);
    }
}
