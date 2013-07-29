<?php

class Login_Model extends Users_Model
{

	public function logout()
	{
		$logged_in_user_id = LoggedInUser::getUserID();

		$stmt = $this->connection->prepare("DELETE FROM " . REGISTRY_TBLNAME_SESSIONS . "
						    WHERE userid=?");
		$stmt->bind_param("i", $logged_in_user_object->getID());

		$stmt->execute();
	}

	public function doesPasswordMatch($user_id, $password)
	{
		$user_password = $this->fetchUserPassword($user_id);
		$user_lowercase_username = $this->fetchUserLowercaseUsername($user_id);
		$encrypted_inputted_password = PNet::OneWayEncryption($password, $user_lowercase_username);

		return ($user_password == $encrypted_inputted_password);
	}

	public function doesPasswordMatchLegacy($password)
	{
		if ($this->userid == null)
		{
			PNet::EngineError("You must perform a user existence check before performing a password match check!");
		}
		else
		{
			$user_object = new User($this->userid);
			if ($user_object->getLegacyPassword() == PNet::OneWayEncryption($password, null, "multi-md5") and $user_object->getLegacyPassword() != null)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	public function createSession($user_id)
	{
		$code1 = rand(0, 999999);
		$code2 = rand(0, 999999);

		$code1 = PNet::OneWayEncryption($code1, "session", "multi-md5");
		$code2 = PNet::OneWayEncryption($code2, "session", "multi-md5");

		$expiry = date("U") + 5184000;

		$stmt = $this->connection->prepare("INSERT INTO " . REGISTRY_TBLNAME_SESSIONS . " (id, userid, code1, code2, expires)
							    VALUES(NULL, ?, ?, ?, ?)");
		$stmt->bind_param("issi", $user_id, $code1, $code2, $expiry);

		$stmt->execute();

		$this->createCookie($code1.".".$code2, $user_id);
	}

	private function createCookie($code, $user_id)
	{
		setcookie(REGISTRY_COOKIES_USER, intval($user_id), time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
		setcookie(REGISTRY_COOKIES_SESSION, $code, time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
	}

}

?>