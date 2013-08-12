# Potato Seed

Potato Seed is a user account framework, written in PHP.

Seed is a lightweight framework, providing the bare basics to allow the creation of user-oriented websites, services and applications.

Seed is an open-source project. Feel free to fork it, modify it and redistribute it. 

## Use

A more in-depth guide will be published shortly. This section is intended to demonstrate the ease of integrating Potato Seed into your own system.

	<?php
	include("registry.php");
	require(REGISTRY_ENGINE_PATH."Seed_Loader.php");
	Seed_Loader::initSeed();

	if (LoggedInUser::isLoggedin())
	{
		echo "Hello, user!";
	}
	else
	{
		echo "You are not logged in. <a href='login.php'>Log in, pelase</a>!";
	}

	?>
