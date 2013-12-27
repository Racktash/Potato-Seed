<?php
class Login_Controller extends Controller
{
    public function execute()
    {
        if($this->loginAttemptPresent())
        {
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
