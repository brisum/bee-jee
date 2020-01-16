<?php

namespace App\Controller;

use App\Utils\Doctrine\DoctrineService;
use App\Utils\RouteService;
use App\Utils\Task\TaskPaginationService;
use App\Utils\Task\TaskService;
use App\Utils\View;

class MainController
{
    const INDEX_ACTION_NAME = 'main_index';
    const PAGE_ACTION_NAME = 'main_page';

    /**
     * @param DoctrineService $doctrineService
     * @param RouteService $routeService
     * @param View $view
     * @param TaskService $taskService
     * @param TaskPaginationService $taskPaginationService
     * @param int $page
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function indexAction(
        DoctrineService $doctrineService,
        RouteService $routeService,
        View $view,
        TaskService $taskService,
        TaskPaginationService $taskPaginationService,
        $page = 1
    ) {
        $page = max(1, intval($page));
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

        if ('id' == $sort && empty($_GET['order'])) {
            $order = 'desc';
        }

        $view->render(
            'main.php',
            [
                'tasks' => $taskService->getTasksByPage($page, $sort, $order),
                'taskPaginationLinks' => $taskPaginationService->getPaginationLinks(
                    $taskService->getTaskPageCount(),
                    $page,
                    $sort,
                    $order
                ),
                'taskLink' => $routeService->generate(self::INDEX_ACTION_NAME)
            ]
        );
    }
}
