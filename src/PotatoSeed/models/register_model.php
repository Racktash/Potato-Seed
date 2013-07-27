<?php

require_once(REGISTRY_ENGINE_PATH . "models/loginreg_model.php");

class register_model extends loginreg_model
{

    public function createUserAccount($pUsername, $pUsernameLower, $pEmail, $pPassword)
    {
        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
            
        $password_encrypted = PNet::OneWayEncryption($pPassword, $pUsernameLower);

        $date_to_post = date("d/m/Y/U");

        $stmt = $sql->prepare("INSERT INTO " . REGISTRY_TBLNAME_USERS . " (id, username, lower, email, password, admin, joinDate)
                    VALUES(NULL, ?, ?, ?, ?, '0', ?)");
        $stmt->bind_param("sssss", $pUsername, $pUsernameLower, $pEmail, $password_encrypted, $date_to_post);
        
        $stmt->execute();
        
        //did we have any problems?
        if($stmt->errno != 0)
        {
            PNet::EngineError("Error creating account! Please contact admin.");
            exit();
        }
        
        $stmt->free_result();
        $sql->close();
    }//create new user account

}

?>