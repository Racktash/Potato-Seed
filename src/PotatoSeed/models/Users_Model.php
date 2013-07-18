<?php
class Users_Model extends Model
{

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
