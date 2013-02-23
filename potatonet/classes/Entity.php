<?php
class Entity
{
    protected $id, $doesExist=false;
    
    public function returnDoesExist()
    {
        return $this->doesExist;
    }//return doesExist
    
    public function returnID()
    {
        return $this->id;
    }
    
}
?>
