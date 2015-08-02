<?php 
    ini_set('error_reporting', E_ALL & ~E_NOTICE);
    ini_set("display_errors", 1);

    
    require_once "../vendor/autoload.php";

    /**
     * Register Whoops
     */
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();

    /**
     * Create new Pinterest instance
     * 
     * @var DirkGroenen\Pinterest\Pinterest
     */
    $pinterest = new DirkGroenen\Pinterest\Pinterest("", "");
?> 