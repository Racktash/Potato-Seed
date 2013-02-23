<?php
require_once(REGISTRY_SEEDBASE_PATH."models/login_model.php");
class controller_login extends Controller
{
    private $login_errors = false;
    public function execute()
    {
        //Load the model
        $this->model = new login_model();
        
        //Check for get and post information...
        $passer = $_POST['passer'];
        $logout = $_GET['logout'];
        
        if($logout == "yes" and LoggedInUser::isLoggedin())
            $this->logout();
        
        
        if (LoggedInUser::isLoggedin() and $logout != "yes")
            $this->alreadyLoggedin();
        
        if($passer == "PASS")
        {
            $this->attemptLogin();
        }
        
        
        
        $this->viewLoginform();
        
    }
    
    //functions
    
    private function alreadyLoggedin()
    {
        header("Location: " . REGISTRY_POST_LOGIN_REDIRECT_TO);
        echo "You're already logged in... <a href='" . REGISTRY_POST_LOGIN_REDIRECT_TO . "'>continue</a>";
        exit();
    }
    
    private function logout()
    {
        //Cookie Clearout
        # Remove our cookies
        setcookie("user", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
        setcookie("session", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
        
        $this->model->logout();
    }
    
    private function attemptLogin()
    {
        $username = psafe($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
        $username_lowercase = strtolower($username);
        $password = $_POST['password'];

        if (!$this->model->doesUserExist($username))
        {
            $this->login_errors = true;
            $this->validation_errors[] = "Couldn't log in - no user with that username could be found.";
        }// we have no users...
        else
        {
            if ($this->model->doesPasswordMatch($password))
            {
                //Create the session
                $this->model->createSession();
                
                //Log in
                LoggedInUser::login($id_on_record);
                $this->alreadyLoggedin();
                
            }//pasword does match
            else
            {
                $this->login_errors = true;
                $this->validation_errors[] =  "Couldn't log in - password does not match that which is on record.";
            }//password does not match
        }//user found
    }
    
    //Views
    private function viewLoginform()
    {
        $this->page_title = "Log In";
        $this->inner_view = "loginform.php";
    }

}
?>
