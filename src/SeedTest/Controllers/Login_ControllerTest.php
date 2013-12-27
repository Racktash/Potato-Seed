<?php
define("REGISTRY_LOGIN_VIEW_FORM", "loginform.php");

require_once 'Seed/entities/Controller.php';
require_once 'Seed/controllers/Login_Controller.php';
require_once 'SeedTestHelpers/TestableLogin_Controller.php';

class Login_ControllerTest extends PHPUnit_Framework_TestCase
{
    private function newLoginController()
    {
        return new TestableLogin_Controller();
    }

    public function test_Execute_NoSubmission_InnerViewLoginForm()
    {
        $empty_input = array();
        $login_c = $this->newLoginController();

        $login_c->setTestInput($empty_input);
        $login_c->execute();
        $inner_view = $login_c->getInnerView();

        $this->assertEquals($inner_view, REGISTRY_LOGIN_VIEW_FORM); 
    }

    public function test_Execute_SubmissionNoValues_ErrorMessages()
    {
        $input = array();
        $input["submit"] = 1;
        $login_c = $this->newLoginController();

        $login_c->setTestInput($input);
        $login_c->execute();
        $errors = $login_c->getValidationErrors();
        $error = $errors[0];
       
        $this->assertContains("Please fill in", $error);
    }

    public function test_Execute_SubmissionUsernameOnly_ErrorMessages()
    {
        $input = array();
        $input["submit"] = 1;
        $input["username"] = "Someuser";
        $login_c = $this->newLoginController();

        $login_c->setTestInput($input);
        $login_c->execute();
        $errors = $login_c->getValidationErrors();
        $error = $errors[0];
       
        $this->assertContains("Please fill in", $error);
    }

    public function test_Execute_SubmissionPasswordOnly_ErrorMessages()
    {
        $input = array();
        $input["submit"] = 1;
        $input["password"] = "pass";
        $login_c = $this->newLoginController();

        $login_c->setTestInput($input);
        $login_c->execute();
        $errors = $login_c->getValidationErrors();
        $error = $errors[0];
       
        $this->assertContains("Please fill in", $error);
    }

    public function test_Execute_SubmissionInvalidUser_ErrorMessages()
    {
        $input = array();
        $input["submit"] = 1;
        $input["username"] = "invalid";
        $input["password"] = "pass";
        $login_c = $this->newLoginController();

        $login_c->setTestInput($input);
        $login_c->execute();
        $errors = $login_c->getValidationErrors();
        $error = $errors[0];
       
        $this->assertContains("Unable to log in", $error);
    }

    public function test_Execute_SubmissionValidUser_SuccessfulLogin()
    {
        $input = array();
        $input["submit"] = 1;
        $input["username"] = "valid";
        $input["password"] = "pass";
        $login_c = $this->newLoginController();

        $login_c->setTestInput($input);
        $login_c->execute();
        $success = $login_c->getLoginSuccess();
       
        $this->assertTrue($success);
    }
}
?>
