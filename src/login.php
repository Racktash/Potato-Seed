<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();

require_once(REGISTRY_ENGINE_PATH."controllers/Login_Controller.php");

if (REGISTRY_CAN_LOGIN)
{
    $reset = $_GET['reset'];

    if($reset == "yes")
        $controller_object = new PasswordReset_Controller();
    else
        $controller_object = new Login_Controller();
    
    //Perform controller execution
    $controller_object->execute();

    //Display page view as defined in the registry
    require(REGISTRY_ENGINE_PATH."views/".REGISTRY_LOGIN_VIEW_PAGE);

}//check if we are allowed to login
?>
