<?php

define("BOOT", "yes");

function return_boot()
{
    return BOOT;
}

//Magic Quotes
# If Magic Quotes are enabled, strip our arrays
if (get_magic_quotes_gpc())
{
    foreach ($_GET as $key => $value)
        $_GET[$key] = stripslashes($value);

    foreach ($_REQUEST as $key => $value)
        $_REQUEST[$key] = stripslashes($value);

    foreach ($_POST as $key => $value)
        $_POST[$key] = stripslashes($value);

    foreach ($_COOKIE as $key => $value)
        $_COOKIE[$key] = stripslashes($value);
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

require(REGISTRY_ENGINE_PATH . "classes.php");

require("eng/functions.php");
require("version.php");

define("FRAMEWORK_VERSION_MAJOR", 1);
define("FRAMEWORK_VERSION_MINOR", 0);

//Login Checks
# Check if there is a logged in user browsing the page
require("eng/loggedin.php");
?>
