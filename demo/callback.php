<?php 
    ini_set('error_reporting', E_ALL);
    ini_set("display_errors", 1);

    header("Content-type: Application/json");
    
    require_once "../vendor/autoload.php";

    $pinterest = new DirkGroenen\Pinterest\Pinterest("4781746819187084805", "391dfbaa705cfbdfb15c5cc869dffdd4fbd43d0d2b38f327b64cc668d52934ff");

    if( isset($_GET["access_token"]) ){
        setcookie("access_token", $_GET["access_token"], time()+3600*24*30);
    }
    else if(!isset($_COOKIE["access_token"])){
        echo "No access token received";
        die();
    }
    
    
    // Set the access token
    $pinterest->auth->setOAuthToken( $_COOKIE["access_token"]  );

    // Get the user's profile information
    $boards = $pinterest->users->getMeFollowingUsers();

    echo $boards;
    
?>