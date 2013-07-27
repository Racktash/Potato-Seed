<?php
require("eng/boot.php");
require_once(REGISTRY_ENGINE_PATH."controllers/register.php");

if (REGISTRY_CAN_REGISTER)
{
    //Create controller object
    $controller_object = new controller_register();
    
    //Perform controller execution
    $controller_object->execute();
    
    //Display page view as defined in the registry
    require(REGISTRY_ENGINE_PATH."views/".REGISTRY_REGISTER_VIEW_PAGE);
    
}//check if we are allowed to login
?>
