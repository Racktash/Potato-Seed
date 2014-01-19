# Potato Seed

Potato Seed is a user account framework, written in PHP.

Seed is a lightweight framework, providing the bare basics to allow the creation of user-oriented websites, services and applications.

## Use

	<?php

	require "registry.php";
	require REGISTRY_ENGINE_PATH . "Seed_Loader.php";
	Seed_Loader::initSeed();

	if (LoggedIn::isLoggedin())
	{
		echo "Hello, user!";
	}
	else
	{
		echo "You are not logged in. <a href='login.php'>Log in, pelase</a>!";
	}

	?>
