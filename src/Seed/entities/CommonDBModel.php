<?php
abstract class CommonDBModel extends DBModel
{
    protected $table_name;
    protected $val_errors;
    protected $required_fields;

    public function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }

    public function insert($data)
    {
        if($this->isValid($data))
        {
            $sql = $this->generateInsertStatement();
            $stmt = $this->handle->prepare($sql);
            $data = $this->generateParamAssocArray($data);

            $this->executeParam($stmt, $data);
        }
        else throw new Exception("Invalid data provided.");
    }

    abstract protected function isValid($data);

    protected function generateInsertStatement()
    {
        $statement = "INSERT INTO " . $this->table_name . "(";
        $required_fields_str = implode(", ", $this->required_fields);

        $statement .= $required_fields_str . ") VALUES (";
        $param_fields = $this->generateParamArray($this->required_fields);

        $fields_str = implode(", ", $param_fields);
        $statement .= $fields_str . ")";
        
        return $statement;
    }

    protected function generateParamArray($array)
    {
        foreach($array as $field)
        {
            $param_field[] = ":".$field;
        }

        return $param_field;
    }

    protected function generateParamAssocArray($array)
    {
        foreach($array as $field => $value)
        {
            $param_field[":".$field] = $value;
        }

        return $param_field;
    }
    
    public function find($field, $value)
    {
        $stmt = $this->handle->prepare("SELECT * FROM ".$this->table_name." WHERE ".$field." = ?");
        $stmt->bindParam(1, $value);
        $this->execute($stmt);

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result == null)
            throw new Exception("No record could be found."); 

        return $result;
         
    }

    public function delete($field, $value)
    {
        $stmt = $this->handle->prepare("DELETE FROM ".$this->table_name." WHERE ".$field." = ?");
        $stmt->bindParam(1, $value);
        $this->execute($stmt);
    }

    public function save($object, $id_field="id")
    {
        $obj_array = (array) $object;
        if($this->isValid($obj_array))
        {
            $sql = $this->generateUpdateStatement($id_field, $obj_array);
            $stmt = $this->handle->prepare($sql);
            $this->executeParam($stmt, $obj_array);
        }
        else throw new Exception("Invalid data provided!");
    }

    protected function generateUpdateStatement($field, $params)
    {
        $sql_statement .= "UPDATE ".$this->table_name. " SET ";
        foreach($params as $key => $value)
        {
            $update_statements[] .= $key . " = :".$key;
        }

        $sql_statement .= implode(", ", $update_statements) . " WHERE " .$field . " = :".$field;

        return $sql_statement;
    }

    public function getValidationErrors()
    {
        return $this->val_errors;
    }
}
?>
