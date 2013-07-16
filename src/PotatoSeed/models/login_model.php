<?php

require_once(REGISTRY_SEEDBASE_PATH . "models/loginreg_model.php");

class login_model extends loginreg_model
{

	public function __construct()
	{
		//do nothing
	}

	public function logout()
	{
		//Session Clearout
		# Remove all active sessions from database
		$sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

		$logged_in_user_object = LoggedInUser::getInstance();

		$stmt = $sql->prepare("DELETE FROM " . REGISTRY_TBLNAME_SESSIONS . "
            WHERE userid=?");
		$stmt->bind_param("i", $logged_in_user_object->getID());
		$stmt->execute();
		$stmt->free_result();

		$sql->close();
	}

	public function doesPasswordMatch($pPassword)
	{
		if ($this->userid == null)
		{
			PNet::EngineError("You must perform a user existence check before performing a password match check!");
		}//user id is null
		else
		{
			$user_object = new User($this->userid);
			if ($user_object->getPassword() == PNet::OneWayEncryption($pPassword, $user_object->getLower()))
			{
				return true;
			}//password matches, when encrypted, the password on record
			else
			{
				return false;
			}//password does not match
		}//user id is not null, continue
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

//does password match

	public function createSession()
	{
		if ($this->userid == null)
		{
			PNet::EngineError("You must perform a user existence check before performing a session creation!");
		}//user id is null
		else
		{
			//Session Create
			# Creates a new session for  this user to use, along with an expiry value

			$code1 = rand(0, 999999);
			$code2 = rand(0, 999999);

			$code1 = PNet::OneWayEncryption($code1, "session", "multi-md5");
			$code2 = PNet::OneWayEncryption($code2, "session", "multi-md5");

			$sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);

			$stmt = $sql->prepare("INSERT INTO " . REGISTRY_TBLNAME_SESSIONS . " (id, userid, code1, code2, expires)
                    VALUES(NULL, ?, ?, ?, ?)");
			$expiry = date("U") + 5184000;
			$stmt->bind_param("issi", $this->userid, $code1, $code2, $expiry);
			$stmt->execute();

			$stmt->free_result();

			$next_year = date("U", mktime(0, 0, 0, date("m") + 2, date("d"), date("Y"))); #cookie expiration date
			//Set Cookies
			# Set our cookies for our logged in user
			setcookie(REGISTRY_COOKIES_USER, psafe($this->userid), time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
			setcookie(REGISTRY_COOKIES_SESSION, $code1 . "." . $code2, time() + 31556926, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);


			$sql->close();
		}
	}

}

?>