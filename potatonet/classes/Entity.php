<?php
class Entity
{
    protected $id, $doesExist=false;
    
    public function getDoesExist()
    {
        return $this->doesExist;
    }
    
    public function getID()
    {
        return $this->id;
    }
    
}
?>
