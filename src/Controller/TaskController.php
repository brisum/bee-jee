<?php

namespace App\Controller;

use App\Entity\Task;
use App\Utils\Doctrine\DoctrineService;
use App\Utils\EmailValidator;
use App\Utils\RouteService;
use App\Utils\Security\SecurityService;
use App\Utils\Task\TaskService;
use App\Utils\View;

class TaskController
{
    const NEW_ACTION_NAME = 'task_new';
    const CREATE_SUCCESS_ACTION_NAME = 'task_create_success';
    const EDIT_ACTION_NAME = 'task_edit_action';

    /**
     * @param RouteService $routeService
     * @param View $view
     * @param TaskService $taskService
     * @param EmailValidator $emailValidator
     */
    public function newAction(
        RouteService $routeService,
        View $view,
        TaskService $taskService,
        EmailValidator $emailValidator
    ) {
        $errors = [];
        $request = [
            'username' => '',
            'email' => '',
            'description' => '',
        ];

        if ('post' == strtolower($_SERVER['REQUEST_METHOD'])) {
            $request = $_POST;
            $request['username'] = htmlentities(strip_tags($request['username']));
            $request['email'] = htmlentities(strip_tags($request['email']));
            $request['description'] = htmlentities(strip_tags($request['description']));

            if (empty($request['username'])) {
                $errors[] = 'Please, enter username.';
            }
            if (empty($request['email'])) {
                $errors[] = 'Please, enter email.';
            } elseif (!$emailValidator->isValid($request['email'])) {
                $errors[] = 'Invalid email.';
            }
            if (empty($request['description'])) {
                $errors[] = 'Please, enter description.';
            }

            if (empty($errors)) {
                $task = $taskService->createFromRequest($request);
                $targetUrl = $routeService->generate(self::CREATE_SUCCESS_ACTION_NAME, ['task' => $task->getId()]);
                header("Location: {$targetUrl}", true, 302);
                die();
            }
        }

        $view->render(
            'task/new.php',
            [
                'errors' => $errors,
                'formAction' => $routeService->generate(self::NEW_ACTION_NAME),
                'request' => $request
            ]
        );
    }

    /**
     * @param DoctrineService $doctrineService
     * @param View $view
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createSuccessAction(
        DoctrineService $doctrineService,
        View $view
    ) {
        $em = $doctrineService->getEntityManager();
        $taskId = isset($_GET['task']) ? intval($_GET['task']) : null;
        $task = $taskId ? $em->getRepository(Task::class)->find($taskId) : null;

        $view->render(
            'task/create-success.php',
            [
                'task' => $task
            ]
        );
    }

    public function editAction(
        DoctrineService $doctrineService,
        RouteService $routeService,
        SecurityService $securityService,
        View $view,
        TaskService $taskService,
        EmailValidator $emailValidator,
        $taskId
    ) {
        if (!$securityService->isSignedIn()) {
            $targetUrl = $routeService->generate(AuthController::LOGIN_ACTION_NAME);
            header("Location: {$targetUrl}", true, 302);
            die();
        }

        $em = $doctrineService->getEntityManager();
        $taskId = intval($taskId);
        /** @var Task $task */
        $task = $taskId ? $em->getRepository(Task::class)->find($taskId) : null;
        $errors = [];

        if (!$task) {
            $view->render('404.php');
            die();
        }

        if ('post' == strtolower($_SERVER['REQUEST_METHOD'])) {
            $request = $_POST;
            $request['username'] = htmlentities(strip_tags($request['username']));
            $request['email'] = htmlentities(strip_tags($request['email']));
            $request['description'] = htmlentities(strip_tags($request['description']));
            $request['status'] = empty($request['status']) ? TaskService::STATUS_NEW : TaskService::STATUS_DONE;

            if (empty($request['username'])) {
                $errors[] = 'Please, enter username.';
            }
            if (empty($request['email'])) {
                $errors[] = 'Please, enter email.';
            } elseif (!$emailValidator->isValid($request['email'])) {
                $errors[] = 'Invalid email.';
            }
            if (empty($request['description'])) {
                $errors[] = 'Please, enter description.';
            }

            if (empty($errors)) {
                $taskService->updateFromRequest($task, $request);
                $targetUrl = $routeService->generate(self::EDIT_ACTION_NAME, ['taskId' => $task->getId()]);
                header("Location: {$targetUrl}", true, 302);
                die();
            }
        }

        $view->render(
            'task/edit.php',
            [
                'errors' => $errors,
                'task' => $task
            ]
        );
    }
}
