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

	private function fetchUserValue($user_id, $value)
	{
		$stmt = $this->connection->prepare("SELECT ".$value." FROM ".REGISTRY_TBLNAME_USERS." WHERE id = ?");

		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($value);

		if(!$stmt->execute())
			throw new Exception("Unable to retrieve ".$value." for user!");

		$stmt->fetch();
		$stmt->free_result();

		return $value;
	}
}
?>
