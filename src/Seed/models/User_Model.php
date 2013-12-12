<?php
class User_Model extends CommonDBModel
{
    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
        $this->setTableName(REGISTRY_TBLNAME_USERS);

        $this->required_fields = array("username", "lower", "email");
    }

    public function isValid($data)
    {
        $validator = new Validator($data);
        $validator->newRule("username", "Username", "required");
        $validator->newRule("lower", "Username", "required|max_len|10");
        $validator->newRule("email", "Username", "required|min_len|2");

        if($validator->allValid()) return true;
        else
        {
            $this->val_errors = $validator->getErrors();
            return false;
        }
        
    }
}
?>
