<?php
define("REGISTRY_LOGIN_VIEW_FORM", "loginform.php");

require_once 'Seed/entities/Controller.php';
require_once 'Seed/controllers/Login_Controller.php';
require_once 'SeedTestHelpers/TestableLogin_Controller.php';

class TestsLogin_Controller extends PHPUnit_Framework_TestCase
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

    public function test_Execute_Submission_NoInnerView()
    {
    }

}
?>
