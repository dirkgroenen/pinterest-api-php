<?php 
    ini_set('error_reporting', E_ALL);
    ini_set("display_errors", 1);

    require_once "../vendor/autoload.php";

    $pinterest = new DirkGroenen\Pinterest\Pinterest("4781746819187084805", "391dfbaa705cfbdfb15c5cc869dffdd4fbd43d0d2b38f327b64cc668d52934ff");

    $url = $pinterest->auth->getLoginUrl( "https://" . $_SERVER["HTTP_HOST"] . "/demo/callback.php" );

    echo "<a href='" . $url . "'>Authorize</a>";
?>