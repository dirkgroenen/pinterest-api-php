<?php require "boot.php"; ?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <h1>Login with Pinterest</h1>
        <p>Use this <a href="<?php echo $pinterest->auth->getLoginUrl('https://pinterest.dev/demo/callback.php', array('read_public', 'write_public')); ?>">link to login</a> with your Pinterest account.</p>
    </body>
</html>