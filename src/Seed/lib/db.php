<?php
namespace db;
function newPDO()
{
    return new \PDO("mysql:host=".REGISTRY_DBVALUES_SERVER.";dbname=".REGISTRY_DBVALUES_DATABASE, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD);
}
?>
