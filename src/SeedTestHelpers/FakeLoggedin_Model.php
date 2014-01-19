<?php
class FakeLoggedin_Model
{
    public function isSessionValid($userid, $sessionid)
    {
        if($userid == 1 and $sessionid == "53.2")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>
