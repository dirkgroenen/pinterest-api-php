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

            echo $pinterest->pins->edit("503066220857432361", array(
                "note"          => "Noted update"
            ), "id,link,note,url,image");
        ?>

    </body>
</html>