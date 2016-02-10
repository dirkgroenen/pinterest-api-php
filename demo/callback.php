<?php require "boot.php"; ?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
            /*echo $pinterest->boards->edit("dirkgroenen/test-from-api", array(
                "name"          => "Test from API - update",
                "description"   => "Test"
            ));*/

            echo $pinterest->boards->edit("dirkgroenen/test-from-api", array(
                "name"          => "Noted update 2 - API"
            ), "description,creator");
        ?>

    </body>
</html>