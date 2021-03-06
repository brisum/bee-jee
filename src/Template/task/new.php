<?php require __DIR__ . '/../header.php'; ?>

<h1 class="mt-5">New Task</h1>

<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

<form action="<?php echo $formAction; ?>" method="post">
    <div class="form-group">
        <label for="username">
            Username
        </label>
        <input type="text" class="form-control" id="username" name="username"
               value="<?php echo $request['username']; ?>" />
    </div>
    <div class="form-group">
        <label for="username">
            Email
        </label>
        <input type="text" class="form-control" id="email" name="email"
               value="<?php echo $request['email']; ?>"/>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="10" name="description"
        ><?php echo $request['description']; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>




<?php require __DIR__ . '/../footer.php'; ?>
