<?php
class Validator
{
	private $string_to_test = NULL;
	private $is_valid = true;
	private $max_string_length = -1;
	private $min_string_length = -1;
	private $cannot_be_empty = false;
	private $error_string = array();

	public function __construct($string_to_test)
	{
		$this->string_to_test = $string_to_test;
	}

	public function validateString()
	{
		if($this->max_string_length != -1)
			$this->checkLenthMaxValid();

		if($this->min_string_length != -1)
			$this->checkLenthMinValid();

		if($this->cannot_be_empty)
			$this->checkStringEmpty();
	}

	public function getIsValid()
	{
		return $this->is_valid;
	}

	public function getErrorArray()
	{
		return $this->error_string;
	}

	public function setMaxStringLength($max_string_length)
	{
		$this->max_string_length = $max_string_length;
	}

	public function setMinStringLength($min_string_length)
	{
		$this->min_string_length = $min_string_length;
	}

	public function setCannotBeEmpty($cannot_be_empty)
	{
		$this->cannot_be_empty = $cannot_be_empty;
	}

	private function checkLenthMaxValid()
	{
		if(strlen($this->string_to_test) > $this->max_string_length)
		{
			$this->is_valid = false;
			$this->error_string[] = "too long (over ".$this->max_string_length." characters)";
		}
	}
	
	private function checkLenthMinValid()
	{
		if(strlen($this->string_to_test) < $this->min_string_length)
		{
			$this->is_valid = false;
			$this->error_string[] = "too short (under ".$this->min_string_length." characters)";
		}
	}

	private function checkStringEmpty()
	{
		if(trim($this->string_to_test) == null)
		{
			$this->is_valid = false;
			$this->error_string[] = "empty";
		}
	}

	
}
?>
