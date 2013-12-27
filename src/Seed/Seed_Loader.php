<?php

class Seed_Loader
{
	public static function initSeed()
	{
		if (get_magic_quotes_gpc())
			self::stripMagicQuotes();

		self::autoLoadClasses();
		self::loadLibs();
		self::loadVersionFile();
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
            if(substr($class, -11) == "_Controller")
            {
                include REGISTRY_ENGINE_PATH. 'controllers/' . $class . '.php';
            }
            else if(substr($class, -6) == "_Model")
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
	
	private static function loadLibs()
	{
        foreach (glob(REGISTRY_ENGINE_PATH."lib/*.php") as $filename)
            include $filename;
	}

	private static function loadVersionFile()
	{
		require("version.php");
	}

	private static function markSuccessfulBoot()
	{
		define("BOOT", true);
	}

}

?>
