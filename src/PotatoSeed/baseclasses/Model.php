<?php
abstract class Model
{
	protected $connection;

	public function __construct(mysqli $connection)
	{
		$this->connection = $connection;	
	}

	public function __destruct()
	{
		$this->connection->close();	
	}
}
?>
