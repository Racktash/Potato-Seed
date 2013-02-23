<?php
class User extends Entity
{
    protected $username, $lower, $email, $password, $avatar, $admin, $tags, $joinDate, $banned;
    
    public function __construct($pUserid, $pUsername="-999")
    {
        $sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
        if($pUsername == "-999")
        {
            $stmt = $sql->prepare("SELECT id, username, lower, email, password, avatar, admin, tags, joinDate, banned
                FROM ".REGISTRY_TBLNAME_USERS."
                WHERE id = ?");
            $stmt->bind_param("i", $pUserid);
            
        }//user the userid to locate the user
        else
        {
            PNet::EngineError("Username search support not added yet!");
            exit();
        }//use username to locate
        
        $stmt->bind_result($id, $username, $lower, $email, $password, $avatar, $admin, $tags, $joinDate, $banned);
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
            $this->doesExist = true;
        }
        
        
        $stmt->free_result();
        
        $sql->close();
        //TODO -- load in the variables from the SQL command above
        
    }

    public function returnID()
    {
        return $this->id;
    }//return userName
    
    public function returnUsername()
    {
        return $this->username;
    }//return userName
    
    public function returnLower()
    {
        return $this->lower;
    }//return Lower
    
    public function returnEmail()
    {
        return $this->email;
    }//return Lower    
    
    public function returnPassword()
    {
        return $this->password;
    }//return password
    
    public function returnAvatar()
    {
        return $this->avatar;
    }//return avatar
    
    public function returnAdmin()
    {
        return $this->admin;
    }//return admin
    
    public function returnTags()
    {
        return $this->tags;
    }//return tags
    
    public function returnJoinDate()
    {
        return $this->joinDate;
    }//return join date
    
    public function returnBanned()
    {
        return $this->banned;
    }//return banned
    
    public function banUser()
    {
        //TODO -- create code to ban this user
    }//ban the user
    
}//user class
?>
