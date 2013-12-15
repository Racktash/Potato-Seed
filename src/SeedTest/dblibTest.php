<?php
require 'Seed/lib/db.php';

class dblibTest extends PHPUnit_Framework_TestCase
{
    public function testGenerateUpdateStatement()
    {
        $params["id"] = 5;
        $params["username"] = "SomeUser";
        $params["lower"] = "someuser";

        $update_statement = db\generateUpdateStatement("User", "id", $params);
        $expected_update_statement = "UPDATE User SET id = :id, username = :username, lower = :lower WHERE id = :id";
        $this->assertEquals($update_statement, $expected_update_statement);

        $update_statement = db\generateUpdateStatement("User", "lower", $params);
        $expected_update_statement = "UPDATE User SET id = :id, username = :username, lower = :lower WHERE lower = :lower";
        $this->assertEquals($update_statement, $expected_update_statement);
    }

    public function testGenerateParamArray()
    {
        $array = array("id", "username", "lower");
        $param_array = db\generateParamArray($array);

        $this->assertEquals($param_array[0], ":id");
        $this->assertEquals($param_array[1], ":username");
        $this->assertEquals($param_array[2], ":lower");
    }

    public function testGenreateParamAssocArray()
    {
        $array["username"] = "SomeUser";
        $array["lower"] = "someuser";
        $array["id"] = 5;

        $param_array = db\generateParamAssocArray($array);

        $this->assertEquals($param_array[":username"], "SomeUser");
        $this->assertEquals($param_array[":id"], 5);
        $this->assertEquals($param_array[":lower"], "someuser");
    }

    public function testGenerateSelectStatement()
    {
        $params["username"] = "SomeUser";
        $params["id"] = 5;

        $sql_statement = db\generateSelectStatement("User", $params);
        $expected_sql_statement = "SELECT * FROM User WHERE username = :username AND id = :id";

        $this->assertEquals($sql_statement, $expected_sql_statement);
    }

    public function testGenerateInsertStatement()
    {
        $params["username"] = "SomeUser";
        $params["password"] = "Test";

        $sql_statement = db\generateInsertStatement("User", $params);
        $expected_sql_statement = "INSERT INTO User (username, password) VALUES(:username, :password)";

        $this->assertEquals($sql_statement, $expected_sql_statement);

    }
}
