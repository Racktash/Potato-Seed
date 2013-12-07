<?php
class ResetTickets_Model extends Users_Model
{
    public function resetInProgress($user_id)
    {
        $this->clearExpired();
        $stmt = $this->handle->prepare("SELECT * FROM " . REGISTRY_TBLNAME_RESETTICKETS . " WHERE userid ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);

        $count = 0;
        while($stmt->fetch())
            $count++;

        return ($count > 0);
    }

    public function keyValid($user_id, $key)
    {
        $this->clearExpired();

        $stmt = $this->handle->prepare("SELECT userid, code FROM " . REGISTRY_TBLNAME_RESETTICKETS . " WHERE userid = ? AND code = ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $key, PDO::PARAM_STR);
        $this->execute($stmt);

        $result = $stmt->fetch();

        return ($key == $result->code);
    }

    public function clearExpired()
    {
        $date = intval(date("U"));
        $stmt = $this->handle->prepare("DELETE FROM " . REGISTRY_TBLNAME_RESETTICKETS . " WHERE expires <= ?");
        $stmt->bindParam(1, $date, PDO::PARAM_INT);
        $this->execute($stmt);
    }

    public function newTicket($user_id)
    {
        $expiry_date = intval(date("U")) + (86400*2);
        $code = md5(rand(1, 999999) * rand(1, 999999));
        
        $stmt = $this->handle->prepare("INSERT INTO " . REGISTRY_TBLNAME_RESETTICKETS . " (userid, expires, code)
                                        VALUES (?, ?, ?)");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $expiry_date, PDO::PARAM_INT);
        $stmt->bindParam(3, $code, PDO::PARAM_STR);

        $this->execute($stmt);
    }
}
?>
