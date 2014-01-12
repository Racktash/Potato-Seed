<?php
class Register_Controller extends Controller
{
    public function execute()
    {
        if($this->registerAttemptPresent())
        {
            if($this->inputValid())
            {
                try
                {
                    $this->attemptRegister();
                    $this->registrationSuccessful();
                }
                catch(Exception $e)
                {
                    $this->registrationFailure();
                }
            }
        }
        else
        {
            $this->regForm();
        }
    }

    private function registerAttemptPresent()
    {
        return (array_key_exists("submit", $this->getInputArray()));
    }

    protected function getInputArray()
    {
        return $_GET;
    }

    protected function getInputParam($key)
    {
        return $_GET[$key];
    }

    private function regForm()
    {
        $this->setPageTitle("Register");
        $this->setInnerView(REGISTRY_REGISTER_VIEW_FORM);
    }

    private function inputValid()
    {
        $validator = new Validator($this->getInputArray());

        $validator->newRule("username", "Username", "required");
        $validator->newRule("password1", "Password", "required");
        $validator->newRule("password2", "Password", "required");
        $validator->newRule("email", "Email address", "required");
        $validator->newRule("spam", "Spam check", "required");

        $presence_valid = $validator->allValid();
        
        if(count($validator->getErrors()) > 0)
        {
            foreach($validator->getErrors() as $error)
                $this->addValidationError($error);
        }

        $passwords_valid = ($this->getInputParam("password1") == $this->getInputParam("password2"));

        if(!$passwords_valid) $this->addValidationError("Passwords must match");

        return ($presence_valid and $passwords_valid);
    }

    protected function attemptRegister()
    {
        //attempt the creation of the new user...
    }

    protected function registrationSuccessful()
    {
        //registration was a success
    }

    protected function registrationFailure()
    {
        //registration was a failure
    }
}
?>
