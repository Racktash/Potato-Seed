<?php
class Users_Model extends Model
{
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
}
?>
