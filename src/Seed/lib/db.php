<?php
namespace db;
function newPDO()
{
    return new \PDO("mysql:host=".REGISTRY_DBVALUES_SERVER.";dbname=".REGISTRY_DBVALUES_DATABASE, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD);
}


function generateUpdateStatement($table_name, $id_field, $params)
{
    $sql_statement = "UPDATE ".$table_name. " SET ";
    foreach($params as $key => $value)
    {
        $update_statements[] = $key . " = :".$key;
    }

    $sql_statement .= implode(", ", $update_statements) . " WHERE " .$id_field . " = :".$id_field;

    return $sql_statement;
}

function generateSelectStatement($table_name, $params)
{
    $sql_statement = "SELECT * FROM ".$table_name. " WHERE ";
    foreach($params as $key => $value)
    {
        $select_conditions[] = $key . " = :".$key;
    }
    $sql_statement .= implode(" AND ", $select_conditions);
    return $sql_statement;
}

function generateInsertStatement($table_name, $params)
{
    $sql_statement = "INSERT INTO ".$table_name. " (";

    foreach($params as $key => $value)
    {
        $fields[] = $key;
        $values[] = ":".$key;
    }

    $sql_statement .= implode(", ", $fields).") VALUES(";
    $sql_statement .= implode(", ", $values).")";

    return $sql_statement;
}

function generateParamArray($array)
{
    foreach($array as $field)
    {
        $param_field[] = ":".$field;
    }

    return $param_field;
}

function generateParamAssocArray($array)
{
    foreach($array as $field => $value)
    {
        $param_field[":".$field] = $value;
    }

    return $param_field;
}

?>
