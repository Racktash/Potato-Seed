<?php

class Register_Model extends Users_Model
{

    public function createUserAccount($username, $usernameLower, $email, $password)
    {
        $password_encrypted = PNet::OneWayEncryption($password, $usernameLower);
        $date_to_post = date("d/m/Y/U");

        $stmt = $this->connection->prepare("INSERT INTO " . REGISTRY_TBLNAME_USERS . " (id, username, lower, email, password, admin, joinDate)
                    VALUES(NULL, ?, ?, ?, ?, '0', ?)");
        $stmt->bind_param("sssss", $username, $usernameLower, $email, $password_encrypted, $date_to_post);
        
        if(!$stmt->execute())
		throw new Exception("Error creating new account!");
    }
}

?>