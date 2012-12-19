<?php
define("BOOT", "yes");

function return_boot()
{
    return BOOT;
}
require("registry.php");

//Database Check
$mysql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

    if ($mysql->connect_errno > 0)
    {
        echo "SQL Error -- couldn't connect!";
        exit();
    }
    
$mysql->close();
//End

require(REGISTRY_ENGINE_PATH."classes/classes.php");

require("eng/functions.php");


define("FRAMEWORK_VERSION_MAJOR", 1);
define("FRAMEWORK_VERSION_MINOR", 0);

//Login Checks
# Check if there is a logged in user browsing the page
require("eng/loggedin.php");
?>
