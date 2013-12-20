<?php
abstract class CommonDBModel extends DBModel
{
    protected $table_name;
    protected $val_errors = array();
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

            $sql = db\generateInsertStatement($this->table_name, $data);
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

    public function find($params)
    {
        $select_statement = db\generateSelectStatement($this->table_name, $params) . " LIMIT 0, 1";
        $assoc_params = db\generateParamAssocArray($params);

        $stmt = $this->handle->prepare($select_statement);
        $this->executeParam($stmt, $assoc_params);

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if($result == null)
            throw new Exception("No record could be found."); 

        return $result;
    }

    public function order($order_by, $limit1, $limit2)
    {
        $this->order_statement = " ".$order_by." ";
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

    public function findAll($params)
    {
        $this->handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $select_statement = db\generateSelectStatement($this->table_name, $params) . $this->order_statement ." LIMIT :limit1, :limit2";

        $params["limit1"] = $this->limit1;
        $params["limit2"] = $this->limit2;

        $assoc_params = db\generateParamAssocArray($params);

        $stmt = $this->handle->prepare($select_statement);
        $this->executeParam($stmt, $assoc_params);

        $this->handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

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
