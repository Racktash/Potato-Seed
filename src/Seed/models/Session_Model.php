<?php
class Session_Model extends CommonDBModel
{
    public function __construct(PDO $handle)
    {
        parent::__construct($handle);
        $this->setTableName(REGISTRY_TBLNAME_SESSIONS);
    }

    public function isValid($data, $id_field=NULL)
    {
        parent::isValid($data, $id_field);

        $validator = new Validator($data);
        $validator->newRule("userid", "userid", "required");
        $validator->newRule("code1", "code1", "required");
        $validator->newRule("code2", "code2", "required");
        $validator->newRule("expires", "expires", "required");

        if($validator->allValid()) return true;
        else
        {
            $this->val_errors = array_merge($this->val_errors, $validator->getErrors());
            return false;
        }
    }

    private function generateCode()
    {
        $random_number = rand(1, 99999);
        $random_number2 = rand(1, 99999);

        $random_number_c = $random_number * $random_number2;
        return md5($random_number_c);
    }

    public function newSession($userid)
    {
        $time_to_expire = 2678400; //31 days

        $session["userid"] = $userid;
        $session["code1"] = $this->generateCode();
        $session["code2"] = $this->generateCode();
        $session["expires"] = date("U") + $time_to_expire;

        $this->insert($session);

        return $session;
    }

    public function createCookie($session)
    {
        $time_to_expire = 2678400; //31 days
        $code = $session["code1"].".".$session["code2"];

        setcookie(REGISTRY_COOKIES_USER, intval($session["userid"]), time() + $time_to_expire, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
        setcookie(REGISTRY_COOKIES_SESSION, $code, time() + $time_to_expire, REGISTRY_COOKIE_PATH, REGISTRY_COOKIE_DOMAIN);
    }
}
?>
