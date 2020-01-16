<?php require __DIR__ . '/header.php'; ?>

<?php

use App\Entity\Task;

?>

<h1 class="mt-5">Tasks</h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">
            Username


            <a href="<?php echo $taskLink; ?>?sort=username&order=asc">
                <i class="fa fa-long-arrow-down sort-icon" aria-hidden="true"></i>
            </a>
            <a href="<?php echo $taskLink; ?>?sort=username&order=desc">
                <i class="fa fa-long-arrow-up sort-icon" aria-hidden="true"></i>
            </a>
        </th>
        <th scope="col">
            Email

            <a href="<?php echo $taskLink; ?>?sort=email&order=asc">
                <i class="fa fa-long-arrow-down sort-icon" aria-hidden="true"></i>
            </a>
            <a href="<?php echo $taskLink; ?>?sort=email&order=desc">
                <i class="fa fa-long-arrow-up sort-icon" aria-hidden="true"></i>
            </a>
        </th>
        <th scope="col">
            Description
        </th>
        <th scope="col">
            Status
            <a href="<?php echo $taskLink; ?>?sort=status&order=asc">
                <i class="fa fa-long-arrow-down sort-icon" aria-hidden="true"></i>
            </a>
            <a href="<?php echo $taskLink; ?>?sort=status&order=desc">
                <i class="fa fa-long-arrow-up sort-icon" aria-hidden="true"></i>
            </a>
        </th>
        <?php if ($isAdmin) : ?>
            <th scope="col">
                Actions
            </th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task) : ?>
            <?php /** @var Task $task */ ?>

            <tr>
                <td>
                    <?php echo $task->getUsername(); ?>
                </td>
                <td>
                    <?php echo $task->getEmail(); ?>
                </td>
                <td>
                    <?php if ($task->getIsEditedByAdmin()) : ?>
                        <div class="alert alert-info p-1" role="alert">
                            Edited by Admin
                        </div>
                    <?php endif; ?>
                    <?php echo htmlentities($task->getDescription()); ?>
                </td>
                <td>
                    <?php echo $task->getStatus(); ?>
                </td>
                <?php if ($isAdmin) : ?>
                    <td>
                        <a href="/task/<?php echo $task->getId(); ?>/edit">Edit</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($taskPaginationLinks) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php foreach ($taskPaginationLinks as $taskPaginationLink): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $taskPaginationLink['link']; ?>">
                        <?php echo $taskPaginationLink['text']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
