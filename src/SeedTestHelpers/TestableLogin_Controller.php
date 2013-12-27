<?php
class TestableLogin_Controller extends Login_Controller
{
    protected $test_input;

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
}
?>
