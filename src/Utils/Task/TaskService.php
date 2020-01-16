<?php

namespace App\Utils\Task;

use App\Entity\Task;
use App\Utils\Doctrine\DoctrineService;
use Doctrine\ORM\EntityManager;

class TaskService
{
    const TASK_PER_PAGE = 3;

    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(DoctrineService $doctrineService)
    {
        $this->em = $doctrineService->getEntityManager();
    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTaskPageCount()
    {
        $taskCount = $this->em->getRepository(Task::class)->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return ceil($taskCount / self::TASK_PER_PAGE);
    }

    public function getTasksByPage(int $page, $sort = 'id', $order = 'desc')
    {
        if (!in_array($sort, ['id', 'username', 'email', 'status'])) {
            $sort = 'id';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        return $this->em->getRepository(Task::class)->createQueryBuilder('t')
            ->setMaxResults(TaskService::TASK_PER_PAGE)
            ->setFirstResult(($page-1) * TaskService::TASK_PER_PAGE)
            ->orderBy("t.{$sort}", $order)
            ->getQuery()
            ->getResult();
    }

    public function createFromRequest($request)
    {
        $task = new Task();
        $task->setUsername($request['username']);
        $task->setEmail($request['email']);
        $task->setDescription($request['description']);
        $task->setStatus(self::STATUS_NEW);
        $task->setIsEditedByAdmin(false);

        $this->em->persist($task);
        $this->em->flush($task);

        return $task;
    }
}
