<?php
class TestableRegister_Controller extends Register_Controller
{
    protected $test_input;
    protected $reg_success = false;
    protected $reg_failure = false;

    protected function getInputArray()
    {
        return $this->test_input;
    }

    protected function getInputParam($key)
    {
        return $this->test_input[$key];
    }

    public function setTestInput($input_array)
    {
        $this->test_input = $input_array;
    }

    protected function attemptRegistration()
    {
        if($this->getInputParam("username") == "existinguser")
        {
            throw new Exception("User already exists!");
        }
    }

    protected function registrationSuccessful()
    {
        $this->reg_success = true;
    }

    protected function registrationFailure()
    {
        $this->reg_failure = true;
    }

    protected function collectRegistrationErrors()
    {
        $this->addValidationError("Database errors");
    }

    public function getRegSuccess()
    {
        return $this->reg_success;
    }

    public function getRegFailure()
    {
        return $this->reg_failure;
    }
}
?>