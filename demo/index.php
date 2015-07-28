<?php 
    require_once "vendor/autoload.php";

    $pinterest = new DirkGroenen\Pinterest("4781746819187084805", "391dfbaa705cfbdfb15c5cc869dffdd4fbd43d0d2b38f327b64cc668d52934ff");

    $url = $pinterest->auth->getLoginUrl( "http://" . $_SERVER["HTTP_HOST"] . "demo/callback.php" );

    echo $url;
?>