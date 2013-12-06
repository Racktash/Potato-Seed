<?php
class User
{
	private $username, $email_address, $join_date;

	public function __construct($username, $email_address, $join_date)
	{
		$this->username = $username;
		$this->email_address = $email_address;
		$this->join_date = $join_date;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getEmailAddress()
	{
		return $this->email_address;
	}

	public function getJoinDate()
	{
		return $this->join_date;
	}
}
?>
