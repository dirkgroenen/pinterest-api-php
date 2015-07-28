<?php 
    require_once "../vendor/autoload.php";

    $pinterest = new DirkGroenen\Pinterest\Pinterest("4781746819187084805", "391dfbaa705cfbdfb15c5cc869dffdd4fbd43d0d2b38f327b64cc668d52934ff");

    $pinterest->auth->getOAuthToken()
?>