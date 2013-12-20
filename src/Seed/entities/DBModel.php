<?php
abstract class DBModel
{
	protected $handle;

	public function __construct(PDO $handle)
	{
		$this->handle = $handle;
	}

	public function __destruct()
	{
		$this->handle = null;
	}

    protected function execute($stmt)
    {
        if(!$stmt->execute()) throw new Exception("Error executing SQL! (".$stmt->error.")");
    }

    protected function executeParam($stmt, $param)
    {
        if(!$stmt->execute($param)) throw new Exception("Error executing SQL! (".$stmt->error.")");
    }
}
?>
