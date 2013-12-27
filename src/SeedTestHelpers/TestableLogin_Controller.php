<?php
class TestableLogin_Controller extends Login_Controller
{
    protected $test_input;
    protected $login_success = false;

    public function setTestInput($array)
    {
        $this->test_input = $array;
    }

    public function getInputParam($key)
    {
        return $this->test_input[$key];
    }

    public function getInputArray()
    {
        return $this->test_input;
    }

    public function getLoginInnerView()
    {
        return "loginform.php";
    }

    public function getLoginSuccess()
    {
        return $this->login_success;
    }

    protected function usernamePasswordComboValid()
    {
        return ($this->getInputParam("username") == "valid");
    }

    protected function login()
    {
        $this->login_success = true;
    }
}
?>
