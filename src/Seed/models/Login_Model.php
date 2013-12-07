<?php

class Login_Model extends Users_Model
{

	public function logout($user_id)
	{
		$stmt = $this->handle->prepare("DELETE FROM " . REGISTRY_TBLNAME_SESSIONS . "
						    WHERE userid = ?");
		$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $this->execute($stmt);
	}

	public function doesPasswordMatch($user_id, $password)
	{
		$user_password = $this->fetchUserPassword($user_id);
		$user_lowercase_username = $this->fetchUserLowercaseUsername($user_id);
		$encrypted_inputted_password = PNet::OneWayEncryption($password, $user_lowercase_username);

		return ($user_password == $encrypted_inputted_password);
	}

	public function doesPasswordMatchLegacy($user_id, $password)
	{
		// If the password supplied matches the legacy password on
		// record, and the legacy password isn't blank, then return
		// true
		if ($this->fetchUserLegacyPassword($user_id) == PNet::OneWayEncryption($password, null, "multi-md5") and $this->fetchUserLegacyPassword($user_id) != null)
			return true;
		else
			return false;
	}

	public function createSession($user_id)
	{
		$code1 = rand(0, 999999);
		$code2 = rand(0, 999999);

		$code1 = PNet::OneWayEncryption($code1, "session", "multi-md5");
		$code2 = PNet::OneWayEncryption($code2, "session", "multi-md5");

		$expiry = date("U") + 5184000;

		$stmt = $this->handle->prepare("INSERT INTO " . REGISTRY_TBLNAME_SESSIONS . " (id, userid, code1, code2, expires)
							    VALUES(NULL, ?, ?, ?, ?)");
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $code1, PDO::PARAM_STR);
        $stmt->bindParam(3, $code2, PDO::PARAM_STR);
        $stmt->bindParam(4, $expiry, PDO::PARAM_INT);
        $this->execute($stmt);

		$this->createCookie($code1.".".$code2, $user_id);
	}

	private function createCookie($code, $user_id)
	{
		setcookie(REGISTRY_COOKIES_USER, intval($user_id), time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
		setcookie(REGISTRY_COOKIES_SESSION, $code, time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
	}

}

?>
