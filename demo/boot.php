<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "../vendor/autoload.php";

    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $pinterest = new DirkGroenen\Pinterest\Pinterest(getenv("APP_ID"), getenv("APP_SECRET"));

    if (isset($_GET["code"])) {
        $token = $pinterest->auth->getOAuthToken($_GET["code"]);
        $pinterest->auth->setOAuthToken($token->access_token);

        setcookie("access_token", $token->access_token);
    } else if (isset($_GET["access_token"])) {
        $pinterest->auth->setOAuthToken($_GET["access_token"]);
    } else if (isset($_COOKIE["access_token"])) {
        $pinterest->auth->setOAuthToken($_COOKIE["access_token"]);
    } else {
        assert(false);
    }

?>
