<?php
class Register_Controller extends Controller
{
    private $user_mdl;

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
                    $this->collectRegistrationErrors();
                    $this->registrationFailure();
                }
            }
        }

        $this->regForm();
    }

    private function registerAttemptPresent()
    {
        return (array_key_exists("submit", $this->getInputArray()));
    }

    protected function getInputArray()
    {
        return $_POST;
    }

    protected function getInputParam($key)
    {
        return $_POST[$key];
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

        $spam_valid = true;
        if($presence_valid and strtolower($this->getInputParam("spam")) != strtolower(REGISTRY_SPAM_ANSWER))
        {
            $this->addValidationError("Spam question not answered correctly.");
            $spam_valid = false;
        }
        
        if(count($validator->getErrors()) > 0)
        {
            foreach($validator->getErrors() as $error)
                $this->addValidationError($error);
        }

        $passwords_valid = ($this->getInputParam("password1") == $this->getInputParam("password2"));

        if(!$passwords_valid) $this->addValidationError("Passwords must match");

        return ($presence_valid and $passwords_valid and $spam_valid);
    }

    protected function attemptRegister()
    {
        $this->user_mdl = new User_Model(db\newPDO());
        $user["username"] = display\alphanum($this->getInputParam("username"));

        $formatted_username_password = $this->user_mdl->formatUsernamePassword($user["username"], $this->getInputParam("password1"));
        $user["lower"] = $formatted_username_password["username"];
        $user["password"] = $formatted_username_password["password"];
        $user["email"] = display\email($this->getInputParam("email"));
        $user["joinDate"] = date("jth F o");

        $this->user_mdl->insert($user);
    }

    protected function registrationSuccessful()
    {
        echo "success";
    }

    protected function collectRegistrationErrors()
    {
        if(count($this->user_mdl->getValidationErrors()) > 0)
        {
            foreach($this->user_mdl->getValidationErrors() as $error)
            {
                $this->addValidationError($error);
            }
        }
    }

    protected function registrationFailure()
    {
        echo "failure";
        //registration was a failure
    }
}
?>
