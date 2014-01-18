<?php

class LoggedIn
{
	private static $user_id = null;
	private static $loggedin = false;
	private static $checked = false;
    private static $cookies_array = null;

    public static function reset()
    {
        self::$user_id = null;
        self::$loggedin = false;
        self::$checked = false;
        self::$cookies_array = null;
    }

    public static function setCookiesArray($array)
    {
        self::$cookies_array = $array;
    }

    private static function isCookieSet($key)
    {
        return array_key_exists($key, self::$cookies_array);
    }

    private static function getCookieValue($key)
    {
        return self::$cookies_array[$key];
    }

    private static function checkCookies()
    {
        if(self::isCookieSet(REGISTRY_COOKIES_USER)
           and self::isCookieSet(REGISTRY_COOKIES_SESSION))
        {
            $user_id = self::getCookieValue(REGISTRY_COOKIES_USER);
            $session = self::getCookieValue(REGISTRY_COOKIES_SESSION);

            if($user_id != null and $user_id != ""
               and $session != null and $session != "")
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function isLoggedIn()
    {
        if(self::$cookies_array == null)
            self::$cookies_array = $_COOKIE;

        if(!self::$checked)
        {
            $cookies_check = self::checkCookies();
            self::$loggedin = $cookies_check;

            return self::$loggedin;
        }
        else
        {
            return self::$loggedin;
        }
    }

}

?>
