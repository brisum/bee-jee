<?php require __DIR__ . '/header.php'; ?>

<?php

use App\Entity\Task;

?>

<h1 class="mt-5">Tasks</h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task) : ?>
            <?php /** @var Task $task */ ?>

            <tr>
                <th scope="row">
                    <?php echo $task->getId(); ?>
                </th>
                <td>
                    <?php echo $task->getUsername(); ?>
                </td>
                <td>
                    <?php echo $task->getEmail(); ?>
                </td>
                <td>
                    <?php echo $task->getStatus(); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (1 < $taskPageCount) : ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if (1 < $taskPageCount && 1 < $taskPage) : ?>
                <li class="page-item">
                    <a class="page-link" href="/page/<?php echo $taskPage - 1; ?>/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $taskPageCount; $p++): ?>
                <li class="page-item">
                    <a class="page-link" href="/page/<?php echo $p; ?>/">
                        <?php echo $p; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if (1 < $taskPageCount && $taskPage < $taskPageCount) : ?>
                <li class="page-item">
                    <a class="page-link" href="/page/<?php echo $taskPage + 1; ?>/" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
