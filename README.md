#About

Potato Seed is a lightweight user framework, written in PHP.

Its footprint is small, but it allows you to write user-oriented web-sites easily.

##Quick Use

Step 1: Initialise Potato Seed

     <?php
     include("registry.php");
     require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
     Seed_Loader::initSeed();

Step 2: Write your application. You can check if a user is logged in with the following:

     		if (LoggedInUser::isLoggedin())
