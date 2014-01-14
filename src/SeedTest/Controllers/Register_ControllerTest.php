<?php
define("REGISTRY_REGISTER_VIEW_FORM", "regform.php");
define("REGISTRY_SPAM_ANSWER", "london");

require_once 'Seed/entities/Controller.php';
require_once 'Seed/controllers/Register_Controller.php';
require_once 'SeedTestHelpers/TestableRegister_Controller.php';

class Register_ControllerTest extends PHPUnit_Framework_TestCase
{
    private function newRegisterController()
    {
        return new TestableRegister_Controller();
    }

    private function getValidTestData()
    {
        $test_input["submit"] = "submit";
        $test_input["username"] = "someuser";
        $test_input["password1"] = "somepass";
        $test_input["password2"] = "somepass";
        $test_input["email"] = "someemail@address.com";
        $test_input["spam"] = "london";

        return $test_input;
    }

    public function test_Execute_NoSubmission_InnerViewRegForm()
    {
        $empty_input = array();
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($empty_input);
        $reg_c->execute();
        $inner_view = $reg_c->getInnerView();

        $this->assertEquals($inner_view, REGISTRY_REGISTER_VIEW_FORM);
    }

    public function test_Execute_NoUsername_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        unset($test_input["username"]);
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);

        try
        {
            $reg_c->execute();
            $this->fail("No exception thrown!");
        }
        catch(Exception $e)
        {
            $this->assertContains("Input not supplied", $e->getMessage());
        }
    }

    public function test_Execute_NoPassword1_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        unset($test_input["password1"]);
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);

        try
        {
            $reg_c->execute();
            $this->fail("No exception thrown!");
        }
        catch(Exception $e)
        {
            $this->assertContains("Input not supplied", $e->getMessage());
        }
    }

    public function test_Execute_NoPassword2_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        unset($test_input["password2"]);
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);

        try
        {
            $reg_c->execute();
            $this->fail("No exception thrown!");
        }
        catch(Exception $e)
        {
            $this->assertContains("Input not supplied", $e->getMessage());
        }
    }

    public function test_Execute_NoEmail_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        unset($test_input["email"]);
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);

        try
        {
            $reg_c->execute();
            $this->fail("No exception thrown!");
        }
        catch(Exception $e)
        {
            $this->assertContains("Input not supplied", $e->getMessage());
        }
    }

    public function test_Execute_NoSpam_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        unset($test_input["spam"]);
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);

        try
        {
            $reg_c->execute();
            $this->fail("No exception thrown!");
        }
        catch(Exception $e)
        {
            $this->assertContains("Input not supplied", $e->getMessage());
        }

    }

    public function test_Execute_EmptyUsername_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["username"] = "";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Username must be filled in", $val_errors[0]);
    }

    public function test_Execute_EmptyPassword1_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["password1"] = "";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Password must be filled in", $val_errors[0]);
    }

    public function test_Execute_EmptyPassword2_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["password2"] = "";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Password must be filled in", $val_errors[0]);
    }

    public function test_Execute_EmptyEmail_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["email"] = "";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Email address must be filled in", $val_errors[0]);
    }

    public function test_Execute_EmptySpam_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["spam"] = "";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Spam check must be filled in", $val_errors[0]);
    }

    public function test_Execute_PasswordsDontMatch_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["password1"] = "somepass";
        $test_input["password2"] = "someotherpass";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Passwords must match", $val_errors[0]);
    }

    public function test_Execute_SpamIncorrect_ReturnsValidationError()
    {
        $test_input = $this->getValidTestData();
        $test_input["spam"] = "new york";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();

        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Spam question not answered correctly", $val_errors[0]);
    }

    public function test_Execute_ValidRegistrationAttempt_RegistrationSuccess()
    {
        $test_input = $this->getValidTestData();
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();
        
        $this->assertTrue(count($val_errors) == 0);
        $this->assertTrue($reg_c->getRegSuccess());
    }

    public function test_Execute_ExistingUser_RegistrationFailure()
    {
        $test_input = $this->getValidTestData();
        $test_input["username"] = "existinguser";
        $reg_c = $this->newRegisterController();

        $reg_c->setTestInput($test_input);
        $reg_c->execute();
        $val_errors = $reg_c->getValidationErrors();
        
        $this->assertTrue(count($val_errors) > 0);
        $this->assertContains("Database errors", $val_errors[0]);
        $this->assertTrue($reg_c->getRegFailure());
    }
}
?>
