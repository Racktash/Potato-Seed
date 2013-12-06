<?php

class Seed_Loader
{

	public static function initSeed()
	{
		if (get_magic_quotes_gpc())
			self::stripMagicQuotes();

		self::autoLoadClasses();
		self::checkConnection();
		self::loadHelperFunctions();
		self::loadVersionFile();
		self::loadLoggedIn();
		self::markSuccessfulBoot();
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

	private static function autoLoadClasses()
	{
        function controller_autoloader($class)
        {
            if(substr($class, -10) == "Controller" and $class != "Controller")
            {
                include REGISTRY_ENGINE_PATH. 'controllers/' . $class . '.php';
            }
            else if(substr($class, -5) == "Model" and $class != "Model")
            {
                include REGISTRY_ENGINE_PATH. 'models/' . $class . '.php';
            }
            else
            {
                include REGISTRY_ENGINE_PATH. 'entities/' . $class . '.php';
            }
        }

        spl_autoload_register('controller_autoloader');
	}
	
	private static function loadDataContainers()
	{
		require(REGISTRY_ENGINE_PATH . "datacontainers/User.php");
	}

	private static function checkConnection()
	{
		$msqli_test = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

		if ($mysqli->connect_errno)
			exit("Critical error! Failed to establish connection!");
		
		$msqli_test->close();
	}

	private static function loadHelperFunctions()
	{
        foreach (glob(REGISTRY_ENGINE_PATH."lib/*.php") as $filename)
            include $filename;
	}

	private static function loadBaseModels()
	{
		require(REGISTRY_ENGINE_PATH . "models/Users_Model.php");
	}

	private static function loadVersionFile()
	{
		require("version.php");
	}

	private static function loadLoggedIn()
	{
		require(REGISTRY_ENGINE_PATH . "loggedin.php");
	}

	private static function markSuccessfulBoot()
	{
		define("BOOT", true);
	}

}

?>
