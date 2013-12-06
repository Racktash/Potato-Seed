<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();

$users_mdl = new Users_Model(db\newPDO());

$user = $users_mdl->fetchUser(1);
echo $user->username;

?>
