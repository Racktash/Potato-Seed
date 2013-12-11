<?php
class Rule
{
    protected $input_name;
    protected $field_human_name;

    protected $conditions;

    public function __construct($input_name, $field_human_name)
    {
        $this->input_name = $input_name;
        $this->field_human_name = $field_human_name;
    }

    public function setRequired()
    {
        $conditions["required"] = true;
    }

    public function setMinLen($min_len)
    {
        $conditions["min_len"] = $min_len;
    }

    public function setMaxLen($max_len)
    {
        $conditions["max_len"] = $max_len;
    }
}
?>
