<?php
require("eng/boot.php");
require_once(REGISTRY_SEEDBASE_PATH."controllers/login.php");

if (REGISTRY_CAN_LOGIN)
{
    //Create controller object
    $controller_object = new controller_login();
    
    //Perform controller execution
    $controller_object->execute();
    
    //Display page view as defined in the registry
    require(REGISTRY_SEEDBASE_PATH."views/".REGISTRY_LOGIN_VIEW_PAGE);
    
}//check if we are allowed to login
?>
