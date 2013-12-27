<?php
class Login_Controller extends Controller
{
    public function execute()
    {
        if($this->loginAttemptPresent())
        {
            $this->loginForm();
            $this->attemptLogin();
        }
        else
        {
            $this->loginForm();
        }
    }

    private function loginAttemptPresent()
    {
        return (array_key_exists("submit", $this->getInputArray()));
    }

    private function attemptLogin()
    {
        if($this->usernamePasswordValid())
        {
            $this->checkDatabase();
        }
        else
        {
            $this->addValidationError("Please fill in the required fields.");
        }
    }

    private function usernamePasswordValid()
    {
        if(!array_key_exists("username", $this->getInputArray()))
            return false;

        if($this->getInputParam("username") == null)
            return false;

        if(!array_key_exists("password", $this->getInputArray()))
            return false;

        if($this->getInputParam("password") == null)
            return false;

        return true;
    }

    private function checkDatabase()
    {
        if($this->usernamePasswordComboValid())
        {
            $this->login();
        }
        else
        {
            $this->addValidationError("Unable to log in. Username and password combination appears to be incorrect.");
        }
    }

    protected function usernamePasswordComboValid()
    {
        $user_mdl = new User_Model(db\newPDO());
        $username = strtolower(display\alphanum($this->getInputParam("username")));
        $password = $this->getInputParam("username");
        $password = PNet::OneWayEncryption($password, $username);

        try
        {
            $user = $user_mdl->find(array("lower"=>$username));

            if ($user->password != $password)
                return false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    protected function login()
    {
        //logic to login, create cookies etc.
    }

    private function loginForm()
    {
        $this->setInnerView($this->getLoginInnerView());
        $this->setPageTitle("Log In");
    }

    public function getInputParam($key)
    {
        return $_POST[$key];
    }

    public function getInputArray()
    {
        return $_POST;
    }

    public function getLoginInnerView()
    {
        return REGISTRY_LOGIN_VIEW_FORM;
    }
}
?>
