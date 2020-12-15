<div class="wrap">
    <h1>Products synchronization</h1>
    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
        <input type="submit" value="Sync products">
        <input type="hidden" name="action" value="wpsync-webspark"/>
    </form>
</div>