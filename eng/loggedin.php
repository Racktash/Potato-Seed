<?php

//Logged In
# This script is run to check whether or not a user is logged in or not

if (isset($_COOKIE[REGISTRY_COOKIES_USER]) and isset($_COOKIE[REGISTRY_COOKIES_SESSION]))
{
    $temp_user_id = psafe($_COOKIE[REGISTRY_COOKIES_USER]);

    $temp_sessions = explode(".", $_COOKIE[REGISTRY_COOKIES_SESSION]);
    $temp_sessions[0] = psafe($temp_sessions[0]);
    $temp_sessions[1] = psafe($temp_sessions[1]);

    if (sizeof($temp_sessions) > 2)
    {
        PNet::EngineError("Too many session keys!");
        exit();
    }

    
    //Assume our log in and session checks pass, set them to 'false' if we find something wrong
    $temp_loggedin = true;
    $temp_session_pass = true;
    
    //Establish DB connection
    $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

    //User Check
    # Checks that the user exists and isn't banned
    if (is_numeric($temp_user_id))
    {
        $temp_user_object = new User($temp_user_id);
        if (!$temp_user_object->getDoesExist())
        {
            $temp_loggedin = false;
        }//user account doesn't exist, log in has failed...
    }//user id is numeric, proceed...
    else
    {
        $temp_loggedin = false;
    }//user id is not numeric, log in has failed
    
    //Session Check
    # Check that the session exists and is connected with that user, and hasn't expired
    if ($temp_loggedin)
    {
        if ($temp_sessions[0] == NULL or $temp_sessions[1] == NULL)
        {
            $temp_session_pass = false;
        }//blank session id, session check fails...
        else
        {
            $stmt = $sql->prepare("SELECT expires
                FROM " . REGISTRY_TBLNAME_SESSIONS . "
                WHERE code1 = ?
                AND code2 = ?
                AND userid= ?
                    ORDER BY id DESC
                    LIMIT 0, 1");
            $stmt->bind_param("ssi", $temp_sessions[0], $temp_sessions[1], $temp_user_id);

            $stmt->bind_result($expires);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows < 1)
            {
                $temp_session_pass = false;
            }//could not find any appropriate sessions on the table...
            else
            {
                //Retrieve the expiry date for the session...
                while ($row = $stmt->fetch())
                    $expiry_on_register = $expires;

                //If the date has passed the current date, then the session is out of date and the session check fails...
                if ($expiry_on_register <= date("U"))
                    $temp_session_pass = false;

            }//found a row with the correct details...
            
            $stmt->free_result();
        }//check we have sessions
    }//previous user check passed, let's check the session next...

    
    
    //Log in the user
    # If we had no errors when checking the user accoutn or session...
    # then log the user in using the provided id...
    if ($temp_loggedin and $temp_session_pass)
        LoggedInUser::login($temp_user_id);


}//we have cookies set, check to see if the user and session details match up to an active instance...
?>
