<?php
class User extends Entity
{
    protected $username, $lower, $email, $password, $avatar, $admin, $tags, $joinDate, $banned;
    
    public function __construct($pUserid, $pUsername="-999")
    {
        $obj_sql = new mysqli(REGISTRY_DBVALUES_SERVER, REGISTRY_DBVALUES_USERNAME, REGISTRY_DBVALUES_PASSWORD, REGISTRY_DBVALUES_DATABASE);
        if($pUsername == "-999")
        {
            $user_details = $obj_sql->query("SELECT *
                FROM ".REGISTRY_TBLNAME_USERS."
                    WHERE id ='".$obj_sql->escape_string($pUserid)."'");
        }//user the userid to locate the user
        else
        {
            
        }//use username to locate
        
        while($row = mysqli_fetch_array($user_details))
        {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->avatar = $row['avatar'];
            $this->admin = $row['admin'];
            $this->tags = $row['tags'];
            $this->joinDate = $row['joinDate'];
            $this->banned = $row['banned'];
            $this->email = $row['email'];
            $this->doesExist = true;
        }
        
        
        
        
        $obj_sql->close();
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
