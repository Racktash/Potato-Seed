<?php

class LoggedInUser
{

    private static $instance = null, $loggedin = false, $admin = 0;

    public static function login($pUserid)
    {
        if(self::$instance == null and self::$loggedin == false)
        {
            self::$instance = new User($pUserid);
            self::$loggedin = true;
            self::$admin = self::$instance->returnAdmin();
        }
        else
        {
            //already initialised...
            PNet::EngineError("Attempts to create two logged in users! Revise code.");
            exit();
        }//checker
    }
    
    public static function returnAdmin()
    {
        if(self::$loggedin)
            return self::$admin;
    }
    
    public static function returnInstance()
    {
        if(self::$loggedin)
            return self::$instance;
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
