<?php

define("TEST_USERNAME", "Tintin");
define("TEST_EMAIL", "tintin@herge.com");
define("TEST_DATEJOIN", "01/01/1970");


require("PotatoSeed/datacontainers/User.php");

class TestUsers extends PHPUnit_Framework_TestCase
{
	private $user;

	function setUp()
	{
		$this->user = new User(TEST_USERNAME, TEST_EMAIL, TEST_DATEJOIN);
	}

	function testUsername()
	{
		$this->assertTrue($this->user->getUsername() == TEST_USERNAME);
	}

	function testEmail()
	{
		$this->assertTrue($this->user->getEmailAddress() == TEST_EMAIL);
	}

	function testJoinDate()
	{
		$this->assertTrue($this->user->getJoinDate() == TEST_DATEJOIN);
	}
}
?>
