<?php

class LoggedInUser
{
	private static $user_id = null;
	private static $loggedin = false;

	public static function login($user_id)
	{
		if (self::$user_id == null and self::$loggedin == false)
		{
			self::$user_id = $user_id;
			self::$loggedin = true;
		}
		else
		{
			throw new Exception("Attempts to create two logged in users! Revise code.");
			exit();
		}
	}

	public static function getUserID()
	{
		if (self::$loggedin)
			return self::$user_id;
	}

	public static function isLoggedin()
	{
		return self::$loggedin;
	}

	private function __construct()
	{
		//can't be instantiated...
	}

}

?>
