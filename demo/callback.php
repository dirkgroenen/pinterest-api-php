<?php 
    ini_set('error_reporting', E_ALL);
    ini_set("display_errors", 1);

    header("Content-type: Application/json");
    
    require_once "../vendor/autoload.php";

    $pinterest = new DirkGroenen\Pinterest\Pinterest("4781746819187084805", "391dfbaa705cfbdfb15c5cc869dffdd4fbd43d0d2b38f327b64cc668d52934ff");

    if( isset($_GET["access_token"]) ){
        // Set the access token
        $pinterest->auth->setOAuthToken( $_GET["access_token"] );

        // Get the user's profile information
        $me = $pinterest->getUser("me");

        echo json_encode($me);
    }
    else{
        echo "No access token received";
    }

?>