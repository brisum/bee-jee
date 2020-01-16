<?php require __DIR__ . '/../header.php'; ?>

<?php

use App\Entity\Task;
use App\Utils\Task\TaskService;

/** @var Task $task */

?>

<h1 class="mt-5">Edit Task</h1>

<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

<form action="" method="post">
    <div class="form-group">
        <label for="username">
            Username
        </label>
        <input type="text" class="form-control" id="username" name="username"
               value="<?php echo htmlentities($task->getUsername()); ?>" />
    </div>

    <div class="form-group">
        <label for="username">
            Email
        </label>
        <input type="text" class="form-control" id="email" name="email"
               value="<?php echo htmlentities($task->getEmail()); ?>" />
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="10" name="description"
        ><?php echo htmlentities($task->getDescription()); ?></textarea>
    </div>

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="status" name="status" value="done"
                <?php echo TaskService::STATUS_DONE == $task->getStatus() ? 'checked' : '';?> />
            <label class="form-check-label" for="status">Is done</label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>




<?php require __DIR__ . '/../footer.php'; ?>
