<?php
require("eng/boot.php");
if(REGISTRY_CAN_REGISTER)
{
    $passer = $_POST['passer'];
    $spam = $_POST['spam'];
    
    if($passer == "PASS")
    {
        if(strtolower($spam) != strtolower(REGISTRY_SPAM_ANSWER))
        {
            echo "<div class='msgBad'><span>Can't log in!</span> Anti-spam question was incorrectly answered.</div>";
        }
        else
        {
            //Registration Attempt
            # We've passed the basic spam check, now let's check the details are all fine
            
            $reg_failed = false;
            $reg_errors = Array();
            
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            
            $username = $_POST['username'];
            
            $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
            
            //Password Checks
            if($pass1 == NULL)
            {
                $reg_failed = true;
                $reg_errors[] = "The first password field was empty.";
            }
            if($pass2 == NULL)
            {
                $reg_failed = true;
                $reg_errors[] = "The second password field was empty.";
            }
            if($pass1 != $pass2)
            {
                $reg_failed = true;
                $reg_errors[] = "The two passwords must match.";
            }
            if(strlen($pass1) < 5)
            {
                $reg_failed = true;
                $reg_errors[] = "Password must be at least 5 characters in length.";
            }
            
            //Username checks
            # Do username checks
            $username = psafe($username);
            $username_lower = strtolower($username);
            if(psafe($username) == NULL)
            {
                $reg_failed = true;
                $reg_errors[] = "Username must contain alpha-numeric characters.";
            }
            if(strlen(psafe($username)) < 5 or strlen(psafe($username)) > 80)
            {
                $reg_failed = true;
                $reg_errors[] = "Username must be between 5 and 80 characters in length.";
            }
            
            $user_results = $sql->query("SELECT *
                FROM ".REGISTRY_TBLNAME_USERS."
                WHERE lower='".$sql->escape_string($username_lower)."'");
            
            if($user_results->num_rows > 0)
            {
                $reg_failed = true;
                $reg_errors[] = "Username already in use.";
            }
            
            $email = $_POST['email'];
                        
            //Email Checks
            # Do email checks
            
            if($email == NULL)
            {
                $reg_failed = true;
                $reg_errors[] = "E-mail cannot be left empty.";
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $reg_failed = true;
                $reg_errors[] = "E-mail provided was not a valid e-mail address.";
            }      
            $user_results = $sql->query("SELECT *
                FROM ".REGISTRY_TBLNAME_USERS."
                WHERE email='".$sql->escape_string(pemail($email))."'");
            
            if($user_results->num_rows > 0)
            {
                $reg_failed = true;
                $reg_errors[] = "Email already in use.";
            }
            
            
            if($reg_failed)
            {
                echo "<div class='msgBad'><span>Unable to complete registration request</span> - please see information below:</div>";
                for($count = 0; $count < sizeof($reg_errors); $count++)
                    echo "<div class='msgBad'>".$reg_errors[$count]."</div>";

            }
            else
            {
                $pass1 = PNet::OneWayEncryption($pass1, $username_lower);
                $date_to_post = date("d/m/Y/U");
                $sql->query("INSERT INTO ".REGISTRY_TBLNAME_USERS." (id, username, lower, email, password, admin, joinDate)
                    VALUES(NULL, '".$sql->escape_string($username)."', '".$sql->escape_string($username_lower)."', '".$sql->escape_string(pemail($email))."', '".$sql->escape_string($pass1)."', '0', '".$sql->escape_string($date_to_post)."')");
                echo "<div class='msgGood'>Registration completed!</div>";
            }
            
            $sql->close();
            
        }//spam question check
    }//passer check
    
    
    echo "<form action='register.php' method='POST'>";
    echo "<p><strong>Desired Username:</strong><input type='text' name='username'></p>";
    echo "<p><strong>E-mail Address:</strong><input type='email' name='email'></p>";
    echo "<input type='hidden' name='passer' value='PASS'>";
    echo "<p><strong>Password:</strong><input type='password' name='pass1'></p>";
    echo "<p><strong>Password (repeat):</strong><input type='password' name='pass2'></p>";
    
    echo "<p><strong>".REGISTRY_SPAM_QUESTION.":</strong><input type='text' name='spam'></p>";
    
    echo "<p><input type='submit' value='Register'></p>";
    echo "</form>";
    
}//can register?
?>
