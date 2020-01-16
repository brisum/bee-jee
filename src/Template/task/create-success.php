<?php require __DIR__ . '/../header.php'; ?>

<?php

use App\Entity\Task;

/** @var Task $task */

?>

<h1 class="mt-5">New Task</h1>

<div class="alert alert-success" role="alert">
    Task has been created successfully!
</div>

<?php if ($task) : ?>
    <div class="form-group">
        <label for="username">
            Username:
        </label>
        <p>
            <?php echo $task->getUsername(); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="username">
            Email:
        </label>
        <p>
            <?php echo $task->getEmail(); ?>
        </p>
    </div>
    <div class="form-group">
        <label for="description">
            Description:
        </label>
        <p>
            <?php echo $task->getDescription(); ?>
        </p>
    </div>
<?php endif; ?>




<?php require __DIR__ . '/../footer.php'; ?>
