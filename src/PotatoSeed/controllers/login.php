<?php

require_once(REGISTRY_ENGINE_PATH . "models/Login_Model.php");

class controller_login extends Controller
{

	private $login_errors = false;

	public function execute()
	{
		$this->model = new Login_Model(new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE));

		$this->viewLoginform();

		$passer = $_POST['passer'];
		$logout = $_GET['logout'];

		if ($logout == "yes" and LoggedInUser::isLoggedin())
			$this->logout();

		if (LoggedInUser::isLoggedin() and $logout != "yes")
			$this->alreadyLoggedin();

		if ($passer == "PASS")
			$this->attemptLogin();
		else if ($passer == "PASS2")
			$this->attemptUpdatePassword();
	}

	private function viewLoginform()
	{
		$this->page_title = "Log In";
		$this->inner_view = "loginform.php";
	}

	private function alreadyLoggedin()
	{
		header("Location: " . REGISTRY_POST_LOGIN_REDIRECT_TO);
		echo "You're already logged in... <a href='" . REGISTRY_POST_LOGIN_REDIRECT_TO . "'>continue</a>";
		exit();
	}

	private function logout()
	{
		//Cookie Clearout
		# Remove our cookies
		setcookie("user", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
		setcookie("session", "", time() - 3600, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);

		$this->model->logout();
	}

	private function attemptLogin()
	{
		$username = psafe($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
		$username_lowercase = strtolower($username);
		$password = $_POST['password'];

		if (!$this->model->doesUserExist($username))
		{
			$this->login_errors = true;
			$this->validation_errors[] = "Couldn't log in - no user with that username could be found.";
		}// we have no users...
		else
		{
			if ($this->model->doesPasswordMatch($password))
			{
				$this->model->createSession();

				LoggedInUser::login($id_on_record);
				$this->alreadyLoggedin();
			}
			else if ($this->model->doesPasswordMatchLegacy($password))
			{
				$this->displayLegacyPasswordScreen();
			}
			else
			{
				$this->login_errors = true;
				$this->validation_errors[] = "Couldn't log in - password does not match that which is on record.";
			}
		}
	}

	private function displayLegacyPasswordScreen()
	{
		$this->page_title = "Update Your Password";
		$this->inner_view = "update_legacy_password.php";
	}

	private function attemptUpdatePassword()
	{
		$username = psafe($_POST['username']); #we check our username after it is stripped of non-[a-z0-9] characters
		$username_lowercase = strtolower($username);
		$password = $_POST['password'];

		if (!$this->model->doesUserExist($username))
		{
			$this->displayLegacyPasswordScreen();
			$this->login_errors = true;
			$this->validation_errors[] = "No user with that username could be found.";
		}
		else
		{
			if ($this->model->doesPasswordMatchLegacy($password))
			{
				exit("TODO -- Add logic to update passwords if the two new ones are good enough...");
			}
			else
			{
				$this->displayLegacyPasswordScreen();
				$this->login_errors = true;
				$this->validation_errors[] = "Password does not match that which is on record.";
			}
		}
	}


	public function getLegacyPassword()
	{
		$password = $_POST['password'];
		return pdisplay($password);
	}

	public function getUsername()
	{
		$username = $_POST['username'];
		$filtered_username = psafe($username);
		return $filtered_username;
	}
	
}

?>
