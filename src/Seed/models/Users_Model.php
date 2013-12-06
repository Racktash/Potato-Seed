<?php
class Users_Model extends DBModel
{
	public function userNameExists($user_name)
	{
		$user_name = strtolower($user_name);

		$stmt = $this->handle->prepare("SELECT id FROM ".REGISTRY_TBLNAME_USERS." WHERE lower = ?");
		$stmt->bindParam(1, $user_name, PDO::PARAM_STR);
        $this->execute($stmt);

        while($row = $stmt->fetch(PDO::FETCH_OBJ))
            $result[] = $row;


		return (sizeof($result) > 0);
	}
	
	public function emailExists($email)
	{
		$email_filtered = strtolower($email);
		$email_filtered = display\email($email);

		$stmt = $this->handle->prepare("SELECT id FROM ".REGISTRY_TBLNAME_USERS." WHERE email = ?");
		$stmt->bindParam(1, $email_filtered, PDO::PARAM_STR);
        $this->execute($stmt);

        while($row = $stmt->fetch(PDO::FETCH_OBJ))
            $result[] = $row;

		return (sizeof($result) > 0);
	}
	
	public function userExists($user_id)
	{
		$stmt = $this->handle->prepare("SELECT id FROM ".REGISTRY_TBLNAME_USERS." WHERE id = ?");
		$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);

        while($row = $stmt->fetch(PDO::FETCH_OBJ))
            $result[] = $row;

		return (sizeof($result) > 0);
	}

	public function fetchUserID($username)
	{
        $username = strtolower($username);

        $stmt = $this->handle->prepare("SELECT id FROM ".REGISTRY_TBLNAME_USERS." WHERE lower = ?");
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $this->execute($stmt);
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->id;
	}
	
	public function fetchUser($user_id)
	{
        $stmt = $this->handle->prepare("SELECT username, lower, email, joinDate FROM " . REGISTRY_TBLNAME_USERS . " WHERE id = ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
	}

	protected function fetchUserPassword($user_id)
	{
		return $this->fetchUserValue($user_id, "password");
	}

	protected function fetchUserLowercaseUsername($user_id)
	{
		return $this->fetchUserValue($user_id, "lower");
	}

	protected function fetchUserLegacyPassword($user_id)
	{
		return $this->fetchUserValue($user_id, "legacypassword");
	}

	private function fetchUserValue($user_id, $value)
	{
        $stmt = $this->handle->prepare("SELECT ".$value." FROM " . REGISTRY_TBLNAME_USERS . " WHERE id = ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[$value];
	}

	public function updatePassword($user_id, $new_password)
	{
		$username = $this->fetchUserValue($user_id, "username");
		$hashed_password = $this->hashPassword($username, $new_password);

		$stmt = $this->handle->prepare("UPDATE ".REGISTRY_TBLNAME_USERS." SET password = ? WHERE id = ?");
        $stmt->bindParam(1, $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);
	}

	public function removeLegacyPassword($user_id)
	{
		$stmt = $this->preapre->prepare("UPDATE ".REGISTRY_TBLNAME_USERS." SET legacypassword = '' WHERE id = ?");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);
	}

	protected function hashPassword($username, $password)
	{
		$username_lower = strtolower($username);
		return PNet::OneWayEncryption($password, $username_lower);
	}
}
?>
