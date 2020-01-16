<?php

namespace App\Controller;

use App\Utils\RouteService;
use App\Utils\Security\LoginValidator;
use App\Utils\Security\SecurityService;
use App\Utils\View;

class AuthController
{
    const LOGIN_ACTION_NAME = 'login';
    const LOGOUT_ACTION_NAME = 'logout';

    public function loginAction(
        SecurityService $securityService,
        RouteService $routeService,
        View $view
    ) {
        $username = '';
        $error = '';

        if ('post' == strtolower($_SERVER['REQUEST_METHOD'])) {
            $username = isset($_POST['username']) ? strip_tags($_POST['username']) : '';
            $password = isset($_POST['password']) ? strip_tags($_POST['password']) : '';

            if (!$error) {
                $result = $securityService->signIn($username, $password);

                if (true === $result) {
                    $targetUrl = $routeService->generate(MainController::INDEX_ACTION_NAME);
                    header("Location: {$targetUrl}", true, 302);
                    die();
                } else {
                    $error = $result;
                }
            }
        }

        $view->render(
            'login.php',
            [
                'username' => $username,
                'error' => $error
            ]
        );
    }

    public function logoutAction(
        SecurityService $securityService,
        RouteService $routeService
    ) {
        $securityService->signOut();
        $targetUrl = $routeService->generate(MainController::INDEX_ACTION_NAME);

        header("Location: {$targetUrl}", true, 302);
        die();
    }
}
