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

    $temp_loggedin = true;

    $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

    //User Check
    # Checks that the user exists and isn't banned
    if (is_numeric($temp_user_id))
    {
        $temp_user_object = new User($temp_user_id);
        if ($temp_user_object->returnDoesExist())
        {
            if ($temp_user_object->returnBanned())
            {
                $temp_loggedin = false;
                //echo "E1";
            }
            else
            {
                //okay...
            }
        }//does exist
        else
        {
            $temp_loggedin = false;
            //echo "E2";
        }
    }
    else
    {
        $temp_loggedin = false;
        //echo "E3";
    }

    $temp_session_pass = true;
    //Session Check
    # Check that the session exists and is connected with that user, and hasn't expired
    if ($temp_loggedin)
    {
        if ($temp_sessions[0] == NULL or $temp_sessions[1] == NULL)
        {
            $temp_session_pass = false;
            //echo "E4".$temp_sessions[1];
            //at least one is blank
        }
        else
        {
            $grab_sessions = "SELECT *
                FROM " . REGISTRY_TBLNAME_SESSIONS . "
                WHERE code1 ='" . $sql->escape_string($temp_sessions[0]) . "'
                AND code2 ='" . $sql->escape_string($temp_sessions[1]) . "'
                AND userid='" . $sql->escape_string($temp_user_id) . "'
                    ORDER BY id DESC
                    LIMIT 0, 1";

            $session_results = $sql->query($grab_sessions);

            if ($session_results->num_rows < 1)
            {
                $temp_session_pass = false;
                //echo "E5" . $temp_sessions[0] . $temp_sessions[1] ."num:" .$session_results->num_rows . "|";
                //sorry, no related sessions... not logged in
            }
            else
            {
                while ($row = mysqli_fetch_array($session_results))
                {
                    $expiry_on_register = $row['expires'];
                }

                if ($expiry_on_register <= date("U"))
                {
                    $temp_session_pass = false;
                }
                else
                {
                    //okay, no errors
                }
            }
        }//check we have sessions
    }

    if ($temp_loggedin and $temp_session_pass)
    {
        LoggedInUser::login($temp_user_id);
    }

}
else
{
    //no cookies, so they aren't logged in...
}//basic cookie check
?>
