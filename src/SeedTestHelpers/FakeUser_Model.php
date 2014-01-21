<?php
class FakeUser_Model
{
    public function find($array, $id_field="id")
    {
        if($array["id"] == 1)
        {
            return;
        }
        else
        {
            throw new Exception("Couldn't find user!");
        }
    }
}
?>
