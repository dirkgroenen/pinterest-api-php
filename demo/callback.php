<?php require "boot.php"; ?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <h1>Hey you!</h1>
        <h2>$pinterest->boards->create()</h2>

        <?php echo $pinterest->boards->create(array(
            "name" => "Test from Pinterest API"
        )); ?>

    </body>
</html>