<?php
class User_Model extends CommonDBModel
{
    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
        $this->setTableName(REGISTRY_TBLNAME_USERS);
    }

    public function isValid($data, $id_field=NULL)
    {
        parent::isValid($data, $id_field);

        $validator = new Validator($data);
        $validator->newRule("username", "Username", "required|min_len|3|max_len|64");
        $validator->newRule("lower", "Username", "required|min_len|3|max_len|64");
        $validator->newRule("email", "Email address", "required|min_len|3|max_len|64");
        $validator->newRule("password", "Password", "required|min_len|4");
        $validator->newRule("joinDate", "Join date", "required");

        if(!$this->isEmailValidFormat($data["email"])) return false;

        if($this->exists("lower", $data["lower"], $id_field, $data[$id_field]))
        {
            $this->val_errors[] = "Username is already registered!";
            return false;
        }

        if($this->exists("username", $data["username"], $id_field, $data[$id_field]))
        {
            $this->val_errors[] = "Username is already registered!";
            return false;
        }

        if($this->exists("email", $data["email"], $id_field, $data[$id_field]))
        {
            $this->val_errors[] = "Email is already registered!";
            return false;
        }

        if($validator->allValid()) return true;
        else
        {
            $this->val_errors = array_merge($this->val_errors, $validator->getErrors());
            return false;
        }
    }

    public function isEmailValidFormat($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else
        {
            $this->val_errors[] = "Email supplied was not formatted correctly";
            return false;
        }
    }

    public function formatUsernamePassword($username, $password)
    {
        $return_array["username"] = strtolower(display\alphanum($username));
        $return_array["password"] = PNet::OneWayEncryption($password, $return_array["username"]);
        return $return_array;
    }
}
?>
