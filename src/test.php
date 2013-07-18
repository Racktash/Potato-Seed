<?php
require("registry.php");
require("PotatoSeed/Seed_Loader.php");
Seed_Loader::initSeed();
require("PotatoSeed/models/Users_Model.php");

$model = new Users_Model(new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE));

if($model->userExists(50))
	echo "user 1 exists!";
else
	echo "Doesn't exist!";


?>
