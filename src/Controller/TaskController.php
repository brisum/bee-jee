<?php

namespace App\Controller;

use App\Entity\Task;
use App\Utils\Doctrine\DoctrineService;
use App\Utils\RouteService;
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
     */
    public function newAction(
        RouteService $routeService,
        View $view,
        TaskService $taskService
    ) {
        if ('post' == strtolower($_SERVER['REQUEST_METHOD'])) {
            $request = $_POST;
            $task = $taskService->createFromRequest($request);

            if ($task) {
                $targetUrl = $routeService->generate(self::CREATE_SUCCESS_ACTION_NAME, ['task' => $task->getId()]);
                header("Location: {$targetUrl}", true, 302);
                die();
            }
        }

        $view->render(
            'task/new.php',
            [
                'formAction' => $routeService->generate(self::NEW_ACTION_NAME)
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
        View $view,
        TaskService $taskService,
        $taskId
    ) {
        $em = $doctrineService->getEntityManager();
        $taskId = intval($taskId);
        /** @var Task $task */
        $task = $taskId ? $em->getRepository(Task::class)->find($taskId) : null;

        if (!$task) {
            $view->render('404.php');
            die();
        }

        if ('post' == strtolower($_SERVER['REQUEST_METHOD'])) {
            $request = $_POST;
            $taskService->updateFromRequest($task, $request);

            if ($task) {
                $targetUrl = $routeService->generate(self::EDIT_ACTION_NAME, ['taskId' => $task->getId()]);
                header("Location: {$targetUrl}", true, 302);
                die();
            }
        }

        $view->render(
            'task/edit.php',
            [
                'task' => $task
            ]
        );
    }
}
