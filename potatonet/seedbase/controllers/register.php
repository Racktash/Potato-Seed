<?php
require_once(REGISTRY_SEEDBASE_PATH."models/register_model.php");
class controller_register extends Controller
{

    public function execute()
    {
        $this->model = new register_model();
        $this->page_title = "Register";
        $passer = $_POST['passer'];
        $spam = $_POST['spam'];
        $username = psafe($_POST['username']);
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
            }//spam question not answered correctly
            else
            {
                if(!$this->attemptRegistration($username, $email, $pass1, $pass2))
                {   
                    $this->model->createUserAccount($username, $username_lower, $email, $pass1);
                }//register the user
                else
                {
                    $this->displayForm();
                }//errors
            }//spam question answered correctly
        }//passer
        else
        {
            $this->displayForm();
        }//no submission attempt, display the form
    }//execute
    
    //methods
    private function attemptRegistration($username, $email, $pass1, $pass2)
    {
        $errors = false;
        
        //Validate Username
        if($this->model->doesUserExist($username))
        {
            //Username is already in use
            $errors = true;
            $this->validation_errors[] = "Username already in use!";
        }//error!
        else if(strlen($username) > 80)
        {
            //Username is too long!
            $errors = true;
            $this->validation_errors[] = "Username cannot exceed 80 characters in length!";
        }
        else if($username == null)
        {
            //Username has been left blank
            $errors = true;
            $this->validation_errors[] = "Username must contain alphanumeric characters!";
        }
        
        //Validate email
        if($this->model->doesEmailExist($email))
        {
            $errors = true;
            $this->validation_errors[] = "Email is already being used by a registered account!";
        }//email already in use
        else if(strlen($email) > 255)
        {
            $errors = true;
            $this->validation_errors[] = "Email cannot exceed 255 characters in length!";
        }//email cannot be too long
        else if($email == null)
        {
            $errors = true;
            $this->validation_errors[] = "Email field cannot be left blank and must contain alphanumeric characters!";
        }//email cannot be blank
        
        //Validate Password
        if($pass1 != $pass2)
        {
            $errors = true;
            $this->validation_errors[] = "The two passwords supplied did not match!";
        }//passwords must match
        else if($pass1 == null)
        {
            $errors = true;
            $this->validation_errors[] = "Password cannot be blank!";
        }
        
        
        return $errors;
        
    }
    
    
    //views
    private function displayForm()
    {
        $this->inner_view = REGISTRY_REGISTER_VIEW_FORM;
    }//display the form
    
}//class
?>
