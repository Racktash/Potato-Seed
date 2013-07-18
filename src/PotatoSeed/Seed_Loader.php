<?php

class Seed_Loader
{

	public static function initSeed()
	{
		if (get_magic_quotes_gpc())
			self::stripMagicQuotes();

		self::loadBaseClasses();
		self::loadDataContainers();
		self::checkDatabase();
		self::loadHelperFunctions();
		self::loadVersionFile();
		self::loadLoggedIn();
	}

	private static function stripMagicQuotes()
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

	private static function loadBaseClasses()
	{
		require(REGISTRY_ENGINE_PATH . "baseclasses/Model.php");
	}
	
	private static function loadDataContainers()
	{
		require(REGISTRY_ENGINE_PATH . "datacontainers/User.php");
	}

	private static function checkDatabase()
	{
		echo "TODO -- check database!";
	}

	private static function loadHelperFunctions()
	{
		require(REGISTRY_ENGINE_PATH . "functions.php");
	}

	private static function loadVersionFile()
	{
		require("version.php");
	}

	private static function loadLoggedIn()
	{
		require(REGISTRY_ENGINE_PATH . "loggedin.php");
	}

}

?>
