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

            echo $pinterest->pins->create(array(
                "board"         => "dirkgroenen/test-from-api",
                'image_url'     => 'https://images.unsplash.com/photo-1453974336165-b5c58464f1ed?crop=entropy&fit=crop&fm=jpg&h=1000&ixjsv=2.1.0&ixlib=rb-0.3.5&q=80&w=1925',
                'note'          => 'test',
                'link'          => 'http://tld.com/072AE601DF7DB00445386F5C9CC46F74'
            ));
        ?>

    </body>
</html>