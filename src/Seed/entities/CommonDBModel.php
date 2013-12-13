<?php
abstract class CommonDBModel extends DBModel
{
    protected $table_name;
    protected $val_errors = array();
    protected $required_fields;
    protected $limit1 = 0, $limit2 = 5;
    protected $order_statement = "";

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
            $data = db\generateParamAssocArray($data);
            $this->executeParam($stmt, $data);
        }
        else throw new Exception("Invalid data provided.");
    }

    protected function isValid($data, $id_field=NULL)
    {
        if($id_field == NULL) $data[$id_field] = NULL;
    }

    protected function generateInsertStatement()
    {
        $statement = "INSERT INTO " . $this->table_name . "(";
        $required_fields_str = implode(", ", $this->required_fields);

        $statement .= $required_fields_str . ") VALUES (";
        $param_fields = db\generateParamArray($this->required_fields);

        $fields_str = implode(", ", $param_fields);
        $statement .= $fields_str . ")";
        
        return $statement;
    }

    public function exists($field, $value, $id_field=NULL, $id_value=NULL)
    {
        if($id_field == NULL or $id_value == NULL)
        {
            $stmt = $this->handle->prepare("SELECT * FROM ".$this->table_name." WHERE ".$field." = ?");
            $stmt->bindParam(1, $value);
        }
        else
        {
            $stmt = $this->handle->prepare("SELECT * FROM ".$this->table_name." WHERE ".$field." = ? AND ".$id_field." != ?");
            $stmt->bindParam(1, $value);
            $stmt->bindParam(2, $id_value);
        }

        $this->execute($stmt);

        $result = $stmt->fetch();

        return ($result != null);
    
    }

    public function find($field, $value)
    {
        return $this->findFirst($field, $value);
    }

    public function findFirst($field, $value)
    {
        $stmt = $this->handle->prepare("SELECT * FROM ".$this->table_name." WHERE ".$field." = ? ORDER BY ".$field." ASC LIMIT 0, 1");
        $stmt->bindParam(1, $value);
        $this->execute($stmt);

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result == null)
            throw new Exception("No record could be found."); 

        return $result;
    }

    public function findLast($field, $value)
    {
        $stmt = $this->handle->prepare("SELECT * FROM ".$this->table_name." WHERE ".$field." = ? ORDER BY ".$field." DESC LIMIT 0, 1");
        $stmt->bindParam(1, $value);
        $this->execute($stmt);

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result == null)
            throw new Exception("No record could be found."); 

        return $result;
    }

    public function order($order_by, $limit1, $limit2)
    {
        $this->order_statement = $order_by;
        $this->limit1 = $limit1;
        $this->limit2 = $limit2;
    }

    public function all()
    {
        $sql = "SELECT * FROM ".$this->table_name." ".$this->order_statement." LIMIT ?, ?";
        $stmt = $this->handle->prepare($sql);
        $stmt->bindParam(1, $this->limit1, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->limit2, PDO::PARAM_INT);
        $this->execute($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($results == null)
            throw new Exception("No records could be found."); 

        return $results;
    }

    public function findAll($field, $value)
    {
        $sql = "SELECT * FROM ".$this->table_name." WHERE ".$field." = ? ".$this->order_statement." LIMIT ?, ?";
        $stmt = $this->handle->prepare($sql);
        $stmt->bindParam(1, $value);
        $stmt->bindParam(2, $this->limit1, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->limit2, PDO::PARAM_INT);
        $this->execute($stmt);

        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($results == null)
            throw new Exception("No records could be found."); 

        return $results;
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
        if($this->isValid($obj_array, $id_field))
        {
            $sql = db\generateUpdateStatement($this->table_name, $id_field, $obj_array);
            $stmt = $this->handle->prepare($sql);
            $this->executeParam($stmt, $obj_array);
        }
        else throw new Exception("Invalid data provided!");
    }

    public function getValidationErrors()
    {
        return $this->val_errors;
    }
}
?>
