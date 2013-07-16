<?php
class loginreg_model
{
    protected $userid;
    
    public function doesEmailExist($pEmail)
    {
        $email = pemail($pEmail);

        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

        $stmt = $sql->prepare("SELECT id
            FROM " . REGISTRY_TBLNAME_USERS . "
            WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id);

        $stmt->execute();
        $stmt->store_result();

        while ($result = $stmt->fetch())
            $this->userid = $id;

        if ($stmt->num_rows > 0)
        {
            return true;
        }//we have a record for that
        else
        {
            return false;
        }//no records, no user -- return false

        $stmt->free_result();
        $sql->close();
    }
    
    public function doesUserExist($pUsername)
    {
        $username = psafe($pUsername);
        $username_lowercase = strtolower($username);

        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

        $stmt = $sql->prepare("SELECT id
            FROM " . REGISTRY_TBLNAME_USERS . "
            WHERE lower = ?");
        $stmt->bind_param("s", $username_lowercase);
        $stmt->bind_result($id);

        $stmt->execute();
        $stmt->store_result();

        while ($result = $stmt->fetch())
            $this->userid = $id;

        if ($stmt->num_rows > 0)
        {
            return true;
        }//we have a record for that
        else
        {
            return false;
        }//no records, no user -- return false

        $stmt->free_result();
        $sql->close();
    }
}
?>
