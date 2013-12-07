<?php

class Register_Model extends Users_Model
{

    public function createUserAccount($username, $username_lwr, $email, $password)
    {
        $password_encrypted = $this->hashPassword($username_lwr, $password);
        $date_to_post = date("d/m/Y/U");

        $stmt = $this->handle->prepare("INSERT INTO " . REGISTRY_TBLNAME_USERS . " (id, username, lower, email, password, joinDate)
                    VALUES(NULL, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $username_lwr, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->bindParam(4, $password_encrypted, PDO::PARAM_STR);
        $stmt->bindParam(5, $date_to_post, PDO::PARAM_STR);

        $this->execute($stmt);
    }
}

?>
