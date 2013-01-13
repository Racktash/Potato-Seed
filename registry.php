<?php
//Engine Path
# The path to the major engine functions and classes
define("REGISTRY_ENGINE_PATH", "potatonet/");


//Cookies
# The names of cookies
define("REGISTRY_COOKIES_USER", "ps_user");
define("REGISTRY_COOKIES_SESSION", "ps_session");

//MySQL Table Names
# The names of the tables used by PotatoNet
define("REGISTRY_TBLNAME_USERS", "Users");
define("REGISTRY_TBLNAME_SESSIONS", "Sessions");

//MySQL Details
# The server, database and user details to connect to the MySQL server
define("REGISTRY_DBVALUES_SERVER", "localhost");
define("REGISTRY_DBVALUES_DATABASE", "DB");
define("REGISTRY_DBVALUES_USERNAME", "USER");
define("REGISTRY_DBVALUES_PASSWORD", "PASSWORD");


//Site Settings
# Settings for site
define("REGISTRY_AVATAR_REPO", "");
define("REGISTRY_CAN_REGISTER", true);                      #can the user register from this script?
define("REGISTRY_CAN_LOGIN", true);                         #can the user log in from this script?
define("REGISTRY_LOGIN_PATH", "login.php");                 #path to login page
define("REGISTRY_LOGIN_PATH", "login.php?logout=yes");      #path to log out page
define("REGISTRY_REGISTER_PATH", "register.php");           #path to registration page
define("REGISTRY_POST_LOGIN_REDIRECT_TO", "index.php");     #Page to go to after we've logged in

//Spam Question
# A question asked at key areas to prevent spam bot access
define("REGISTRY_SPAM_QUESTION", "What is the capital of England?");
define("REGISTRY_SPAM_ANSWER", "London");                               #not case-sensitive

//Cookie Settings
# Settings for cookie: path, domain etc...
define("REGISTRY_COOKIE_DOMAIN", ".example.com");
define("REGISTRY_COOKIE_PATH", "/");

//Site Registry
# For site or script specific registry values
if (file_exists("registry_site.php"))
    require("registry_site.php");
else
    exit("Framework Error: Missing Site Registry");
?>
