<?php

require("eng/boot.php");
if (REGISTRY_CAN_LOGIN)
{
    $passer = $_POST['passer'];
    $logout = $_GET['logout'];

//Login Requests
# Processes login requests
    if ($passer == "PASS")
    {
        $login_errors = false;
        $login_error_response = "";

        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
        $username = psafe($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
        $username_lowercase = strtolower($username);
        $password = PNet::OneWayEncryption(stripslashes($_POST['password']), $username_lowercase);

        $grab_users = $sql->query("SELECT *
        FROM " . REGISTRY_TBLNAME_USERS . "
        WHERE lower='" . $sql->escape_string($username_lowercase) . "'");

        if ($grab_users->num_rows < 1)
        {
            $login_errors = true;
            echo "<div class='msgBad'>Couldn't log in - no user with that username could be found.</div>";
        }
        else
        {
            while ($row = mysqli_fetch_array($grab_users))
            {
                $id_on_record = $row['id'];
                $password_on_record = $row['password'];
            }
            if ($password_on_record == $password)
            {
                //Session Create
                # Creates a new session for  this user to use, along with an expiry value

                $code1 = rand(0, 999999);
                $code2 = rand(0, 999999);

                $code1 = PNet::OneWayEncryption($code1, "session", "multi-md5");
                $code2 = PNet::OneWayEncryption($code2, "session", "multi-md5");


                $stmt = $sql->prepare("INSERT INTO " . REGISTRY_TBLNAME_SESSIONS . " (id, userid, code1, code2, expires)
                    VALUES(NULL, ?, ?, ?, ?)");
                $expiry = date("U") + 5184000;
                $stmt->bind_param("issi", $id_on_record, $code1, $code2, $expiry);
                $stmt->execute();
                
                $stmt->free_result();
                
                $next_year = date("U", mktime(0, 0, 0, date("m") + 2, date("d"), date("Y"))); #cookie expiration date
                //Set Cookies
                # Set our cookies for our logged in user
                setcookie("user", psafe($id_on_record), time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
                setcookie("session", $code1 . "." . $code2, time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);

                LoggedInUser::login($id_on_record);
            }
            else
            {
                $login_errors = true;
                echo "<div class='msgBad'>Couldn't log in - password does not match that which is on record.</div>";
            }
        }


        $sql->close();
    }//if we have a login request attempt, let's process it


    if ($logout == "yes" and LoggedInUser::isLoggedin())
    {
        //Cookie Clearout
        # Remove our cookies
        setcookie("user", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
        setcookie("session", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);

        //Session Clearout
        # Remove all active sessions from database
        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

        $logged_in_user_object = LoggedInUser::returnInstance();
        
        $stmt = $sql->prepare("DELETE FROM ".REGISTRY_TBLNAME_SESSIONS."
            WHERE userid=?");
        $stmt->bind_param("i", $logged_in_user_object->returnID());
        $stmt->execute();
        $stmt->free_result();

        $sql->close();
    }//log out of this...

    if (LoggedInUser::isLoggedin() and $logout != "yes")
    {
        header("Location: " . REGISTRY_POST_LOGIN_REDIRECT_TO);
        echo "You're already logged in... <a href='" . REGISTRY_POST_LOGIN_REDIRECT_TO . "'>continue</a>";
        exit();
    }
    else
    {
        echo "<form action='login.php' method='post'>";

        echo "<p><strong>Username</strong><input type='text' name='username'></p>";
        echo "<input type='hidden' name='passer' value='PASS'>";
        echo "<p><strong>Password</strong><input type='password' name='password'></p>";
        echo "<p><input type='submit' value='Log In'></p>";
        echo "</form>";
    }
}//check if we are allowed to login
?>
