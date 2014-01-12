<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();

if (REGISTRY_CAN_REGISTER)
{
    $controller = new Register_Controller();
    $controller->execute();
    require REGISTRY_ENGINE_PATH . "views/" .
            REGISTRY_REGISTER_VIEW_PAGE;
}
?>
