<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();


if (REGISTRY_CAN_REGISTER)
{
    //Create controller object
    $controller_object = new Register_Controller();
    
    //Perform controller execution
    $controller_object->execute();
    
    //Display page view as defined in the registry
    require(REGISTRY_ENGINE_PATH."views/".REGISTRY_REGISTER_VIEW_PAGE);
    
}//check if we are allowed to login
?>
