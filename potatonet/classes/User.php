<?php
class User extends Entity
{
    protected $username, $lower, $email, $password, $avatar, $admin, $tags, $joinDate, $banned, $legacypassword;
    
    public function __construct($pUserid, $pUsername="-999")
    {
        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
        if($pUsername == "-999")
        {
            $stmt = $sql->prepare("SELECT id, username, lower, email, password, avatar, admin, tags, joinDate, banned, legacypassword
                FROM ".REGISTRY_TBLNAME_USERS."
                WHERE id = ?");
            $stmt->bind_param("i", $pUserid);
            
        }
        else
        {
            PNet::EngineError("Username search support not added yet!");
            exit();
        }
        
        $stmt->bind_result($id, $username, $lower, $email, $password, $avatar, $admin, $tags, $joinDate, $banned, $legacypassword);
        $stmt->execute();
        
        while($row = $stmt->fetch())
        {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->avatar = $avatar;
            $this->admin = $admin;
            $this->tags = $tags;
            $this->joinDate = $joinDate;
            $this->banned = $banned;
            $this->email = $email;
            $this->lower = $lower;
            $this->legacypassword = $legacypassword;
            $this->doesExist = true;
        }
        
        $stmt->free_result();
        $sql->close();
    }

    public function getUsername()
    {
        return $this->username;
    }
    
    public function getLower()
    {
        return $this->lower;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getAvatar()
    {
        return $this->avatar;
    }
    
    public function getAdmin()
    {
        return $this->admin;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    public function getLegacyPassword()
    {
	return $this->legacypassword;
    }
}
?>
