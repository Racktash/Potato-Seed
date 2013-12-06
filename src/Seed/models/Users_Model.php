<?php
class Users_Model extends Model
{
	public function userNameExists($user_name)
	{
		$user_name = strtolower($user_name);

		$stmt = $this->connection->prepare("SELECT COUNT(id) FROM ".REGISTRY_TBLNAME_USERS." WHERE lower = ?");

		$stmt->bind_param("s", $user_name);
		$stmt->bind_result($count);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve user details from database!");

		$stmt->fetch();
		$stmt->free_result();

		return ($count > 0);
	}
	
	public function emailExists($email)
	{
		$email_filtered = strtolower($email);
		$email_filtered = pemail($email);

		$stmt = $this->connection->prepare("SELECT COUNT(id) FROM ".REGISTRY_TBLNAME_USERS." WHERE email = ?");

		$stmt->bind_param("s", $email);
		$stmt->bind_result($count);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve user details from database!");

		$stmt->fetch();
		$stmt->free_result();

		return ($count > 0);
	}
	
	public function userExists($user_id)
	{
		$stmt = $this->connection->prepare("SELECT COUNT(id) FROM ".REGISTRY_TBLNAME_USERS." WHERE id = ?");

		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($count);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve user details from database!");

		$stmt->fetch();
		$stmt->free_result();

		return ($count > 0);
	}

	public function fetchUserID($username)
	{
		$username = strtolower($username);

		$stmt = $this->connection->prepare("SELECT id FROM ".REGISTRY_TBLNAME_USERS." WHERE lower = ?");

		$stmt->bind_param("s", $username);
		$stmt->bind_result($user_id);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve user details from database!");

		$stmt->fetch();
		$stmt->free_result();

		return $user_id;
	}
	
	public function fetchUser($user_id)
	{
		$stmt = $this->connection->prepare("SELECT username, email, joindate FROM ".REGISTRY_TBLNAME_USERS." WHERE id = ?");

		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($username, $email, $join_date);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve user details from database!");

		$stmt->fetch();
		$stmt->free_result();

		return new User($username, $email, $join_date);
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
		$stmt = $this->connection->prepare("SELECT ".$value." FROM ".REGISTRY_TBLNAME_USERS." WHERE id = ?");

		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($atr_value);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve ".$value." for user!");

		$stmt->fetch();
		$stmt->free_result();

		return $atr_value;
	}

	public function updatePassword($user_id, $new_password)
	{
		$username = $this->fetchUserValue($user_id, "username");
		$hashed_password = $this->hashPassword($username, $new_password);

		$stmt = $this->connection->prepare("UPDATE ".REGISTRY_TBLNAME_USERS." SET password = ? WHERE id = ?");

		$stmt->bind_param("si", $hashed_password, $user_id);
		
		if(!$stmt->execute())
			throw new Exception("Unable to update password!");
	}

	public function removeLegacyPassword($user_id)
	{
		$stmt = $this->connection->prepare("UPDATE ".REGISTRY_TBLNAME_USERS." SET legacypassword = '' WHERE id = ?");

		$stmt->bind_param("i", $user_id);
		
		if(!$stmt->execute())
			throw new Exception("Unable to remove legacy password!");
	}

	protected function hashPassword($username, $password)
	{
		$username_lower = strtolower($username);
		return PNet::OneWayEncryption($password, $username_lower);
	}
}
?>
