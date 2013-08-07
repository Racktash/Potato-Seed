<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();

require_once(REGISTRY_ENGINE_PATH."controllers/Login_Controller.php");

if (REGISTRY_CAN_LOGIN)
{
    //Create controller object
    $controller_object = new Controller_Login();
    
    //Perform controller execution
    $controller_object->execute();

    //Display page view as defined in the registry
    require(REGISTRY_ENGINE_PATH."views/".REGISTRY_LOGIN_VIEW_PAGE);

}//check if we are allowed to login
?>
