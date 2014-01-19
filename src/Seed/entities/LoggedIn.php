<?php

class LoggedIn
{
	private static $user_id = null;
	private static $loggedin = false;
	private static $checked = false;
    private static $cookies_array = null;
    private static $loggedin_model = null;

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

    public static function setLoggedInModel($loggedin_model)
    {
        self::$loggedin_model = $loggedin_model;
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

    private static function checkDatabase()
    {
        return self::$loggedin_model->isSessionValid(self::getCookieValue(REGISTRY_COOKIES_USER),
                                                     self::getCookieValue(REGISTRY_COOKIES_SESSION));
    }

    public static function isLoggedIn()
    {
        if(self::$cookies_array == null)
            self::$cookies_array = $_COOKIE;

        if(self::$loggedin_model == null)
            self::$loggedin_model = new Loggedin_Model();

        if(!self::$checked)
        {
            $cookies_check = self::checkCookies();

            $db_check = false;
            if($cookies_check) $db_check = self::checkDatabase();

            self::$loggedin = ($cookies_check and $db_check);
            self::$checked = true;

            return self::$loggedin;
        }
        else
        {
            return self::$loggedin;
        }
    }

}

?>
