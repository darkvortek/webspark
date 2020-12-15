<div class="wrap">
    <h1>Import is ended</h1>
    <?php if (!empty($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
            <p style="color: red"><?php echo $error; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <p style="color: green">Created: <?php echo $success['created']; ?></p>
        <p style="color: green">Updated: <?php echo $success['updated']; ?></p>
        <p style="color: green">Deleted old products: <?php echo $success['deleted']; ?></p>
    <?php endif; ?>
    <a href="/wp-admin">Go to admin</a>
</div>