<?php
class PasswordReset_Controller extends Controller
{
    private $reset_mdl; 

    public function execute()
    {
        $this->reset_mdl = new ResetTickets_Model(db\newPDO());

        $user_id = intval($_GET['user_id']);
        $code = display\alphanum($_GET['code']);

        if($this->reset_mdl->keyValid($user_id, $code))
        {
            $this->page_resetForm();
        }
        else
        {
            echo "No reset in progress!";
        }
    }

    private function page_resetForm()
    {
        $this->setPageTitle("Reset Password");
        $this->setInnerView("password_reset_form.php");
    }
}
?>
