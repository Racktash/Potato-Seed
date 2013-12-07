<?php
class Register_Controller extends Controller
{

    public function execute()
    {
        $this->reg_mdl = new Register_Model(db\newPDO());
        $this->page_title = "Register";
        $passer = $_POST['passer'];
        $spam = $_POST['spam'];
        $username = display\alphanum($_POST['username']);
        $username_lower = strtolower($username);
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $email = pemail($_POST['email']);

        if ($passer == "PASS")
        {
            if (strtolower($spam) != strtolower(REGISTRY_SPAM_ANSWER))
            {
                $this->validation_errors[] = "Spam question was not correctly answered.";
                $this->displayForm();
            }
            else
            {
                if (!$this->attemptRegistration($username, $email, $pass1, $pass2))
                {
                    try
                    {
                        $this->reg_mdl->createUserAccount($username, $username_lower, $email, $pass1);
                        $this->displaySuccessPage();
                    }
                    catch(Exception $e)
                    {
                        exit("Critical System error: " . $e->getMessage());
                    }
                }
                else
                {
                    $this->displayForm();
                }
            }
        }
        else
        {
            $this->displayForm();
        }
    }

    private function attemptRegistration($username, $email, $pass1, $pass2)
    {
        $errors = false;

        //TODO Break into separate functions!
        
        //Validate Username
        if ($this->reg_mdl->userNameExists($username))
        {
            $errors = true;
            $this->validation_errors[] = "Username already in use!";
        }
        else if (strlen($username) > 64)
        {
            $errors = true;
            $this->validation_errors[] = "Username cannot exceed 64 characters in length!";
        }
        else if ($username == null)
        {
            $errors = true;
            $this->validation_errors[] = "Username must contain alphanumeric characters!";
        }

        if ($this->reg_mdl->emailExists($email))
        {
            $errors = true;
            $this->validation_errors[] = "Email is already being used by a registered account!";
        }
        else if (strlen($email) > 64)
        {
            $errors = true;
            $this->validation_errors[] = "Email cannot exceed 64 characters in length!";
        }
        else if ($email == null)
        {
            $errors = true;
            $this->validation_errors[] = "Email field cannot be left blank and must contain alphanumeric characters!";
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors = true;
            $this->validation_errors[] = "Email supplied was not formatted correctly.";
        }

        //Validate Password
        if ($pass1 != $pass2)
        {
            $errors = true;
            $this->validation_errors[] = "The two passwords supplied did not match!";
        }
        else if ($pass1 == null)
        {
            $errors = true;
            $this->validation_errors[] = "Password cannot be blank!";
        }


        return $errors;
    }

    private function displayForm()
    {
        $this->setInnerView(REGISTRY_REGISTER_VIEW_FORM);
    }

    private function displaySuccessPage()
    {
        $this->setInnerView("registration_complete.php");
    }

}
?>
