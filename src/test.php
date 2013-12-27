<?php
require("registry.php");
require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
Seed_Loader::initSeed();

$user_model = new User_Model(db\newPDO());
$user_model->order("ORDER BY id DESC", 0, 4);
$users = $user_model->findAll(array("password"=>"test"));

foreach($users as $user)
{
    echo $user->username . "<br />";
}


/*

Current Issue
Can change email to an existing email so long as that email
only exists once. This is a flawed approach

$user = $user_model->find("lower", "joh");
$user->email = "joh2@test.com";

$user_model->save($user);
*/
?>
