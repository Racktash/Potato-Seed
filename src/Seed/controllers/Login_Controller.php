<?php
class Login_Controller extends Controller
{

    private $login_errors = false;
    protected $login_mdl;

    public function execute()
    {
        $this->login_mdl = new Login_Model(db\newPDO());

        $this->viewLoginform();

        $passer = $_POST['passer'];
        $logout = $_GET['logout'];

        if ($logout == "yes" and LoggedInUser::isLoggedin())
        {
            $user_id = LoggedInUser::getUserID();
            $this->logout($user_id);
        }

        if (LoggedInUser::isLoggedin() and $logout != "yes")
            $this->alreadyLoggedin();

        if ($passer == "PASS")
            $this->attemptLogin();
        else if ($passer == "PASS2")
            $this->attemptUpdatePassword();
    }

    private function viewLoginform()
    {
        $this->setPageTitle("Log In");
        $this->setInnerView("loginform.php");
    }

    private function alreadyLoggedin()
    {
        header("Location: " . REGISTRY_POST_LOGIN_REDIRECT_TO);
        echo "You're already logged in... <a href='" . REGISTRY_POST_LOGIN_REDIRECT_TO . "'>continue</a>";
        exit();
    }

    private function logout($user_id)
    {
        setcookie(REGISTRY_COOKIES_USER, "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
        setcookie(REGISTRY_COOKIES_SESSION, "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);

        $this->login_mdl->logout($user_id);
    }

    private function attemptLogin()
    {
        $username = display\alphanum($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
        $username_lowercase = strtolower($username);
        $password = $_POST['password'];

        if (!$this->login_mdl->userNameExists($username))
        {
            $this->login_errors = true;
            $this->validation_errors[] = "Couldn't log in - no user with that username could be found.";
        }// we have no users...
        else
        {
            $user_id = $this->login_mdl->fetchUserID($username);
            if ($this->login_mdl->doesPasswordMatch($user_id, $password))
            {
                $this->login_mdl->createSession($user_id);

                LoggedInUser::login($user_id);
                $this->alreadyLoggedin();
            }
            else if ($this->login_mdl->doesPasswordMatchLegacy($user_id, $password))
            {
                $this->displayLegacyPasswordScreen();
            }
            else
            {
                $this->login_errors = true;
                $this->validation_errors[] = "Couldn't log in - password does not match that which is on record.";
            }
        }
    }

    private function displayLegacyPasswordScreen()
    {
        $this->setPageTitle("Update Your Password");
        $this->setInnerView(REGISTRY_LOGIN_CHANGE_LEGACY_VIEW_FORM);
    }

    private function attemptUpdatePassword()
    {
        $username = display\alphanum($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
        $username_lowercase = strtolower($username);
        $password = $_POST['password'];

        if (!$this->login_mdl->userNameExists($username))
        {
            $this->displayLegacyPasswordScreen();
            $this->login_errors = true;
            $this->validation_errors[] = "No user with that username could be found.";
        }
        else
        {
            $user_id = $this->login_mdl->fetchUserID($username);
            
            if ($this->login_mdl->doesPasswordMatchLegacy($user_id, $password))
            {
                $password1 = $_POST['newpassword1'];
                $password2 = $_POST['newpassword2'];

                if($this->newPasswordsValid($password1, $password2))
                {
                    $this->updatePassword($user_id, $password1);
                    $this->clearLegacyPassword($user_id);
                }   
            }
            else
            {
                $this->displayLegacyPasswordScreen();
                $this->login_errors = true;
                $this->validation_errors[] = "Password does not match that which is on record.";
            }
        }
    }

    private function newPasswordsValid($password1, $password2)
    {
        if($password1 != $password2)
        {
            $this->addValidationError("The two new passwords must match!");
            return false;
        }
        else if ($password1 == "" or $password1 == null)
        {
            $this->addValidationError("New password cannot be empty!");
            return false;
        }
        else
        {
            return true;
        }
    }

    private function updatePassword($user_id, $password)
    {
        $this->login_mdl->updatePassword($user_id, $password);
    }

    private function clearLegacyPassword($user_id)
    {
        $this->login_mdl->removeLegacyPassword($user_id);
    }


    public function getLegacyPassword()
    {
        $password = $_POST['password'];
        return display\html($password);
    }

    public function getUsername()
    {
        $username = $_POST['username'];
        $filtered_username = display\alphanum($username);
        return $filtered_username;
    }
    
}

?>
