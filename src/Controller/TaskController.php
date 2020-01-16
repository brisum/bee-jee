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
}
