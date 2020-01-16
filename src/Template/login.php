<?php require __DIR__ . '/header.php'; ?>

<h1 class="mt-5 text-center">Login</h1>

<div class="row justify-content-md-center">
    <div class="col col-md-6">
        <?php if ($error) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="<?php ?>" method="post">
            <div class="form-group">
                <label for="username">
                    Username
                </label>
                <input type="text" class="form-control" id="username" name="username"
                 value="<?php echo htmlentities($username); ?>"/>
            </div>
            <div class="form-group">
                <label for="password">
                    Password
                </label>
                <input type="password" class="form-control" id="password" name="password" />
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</div>



<?php require __DIR__ . '/footer.php'; ?>
