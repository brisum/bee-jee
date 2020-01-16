<?php

namespace App\Controller;

use App\Entity\Task;
use App\Utils\Doctrine\DoctrineService;
use App\Utils\Task\TaskService;
use App\Utils\View;

class MainController
{
    const INDEX_ACTION_NAME = 'main_index';
    const PAGE_ACTION_NAME = 'main_page';

    /**
     * @param TaskService $taskService
     * @param DoctrineService $doctrineService
     * @param View $view
     * @param int $page
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function indexAction(
        TaskService $taskService,
        DoctrineService $doctrineService,
        View $view,
        $page = 1
    ) {
        $page = max(1, intval($page));

        $view->render(
            'main.php',
            [
                'tasks' => $taskService->getTasksByPage($page),
                'taskPageCount' => $taskService->getTaskPageCount(),
                'taskPage' => $page
            ]
        );
    }
}
