<?php
class Rule
{
    protected $string;
    protected $field_human_name;

    protected $error;

    protected $conditions;

    public function __construct($string, $field_human_name)
    {
        $this->string = $string;
        $this->field_human_name = $field_human_name;

        $this->conditions["required"] = false;
        $this->conditions["min_len"] = 0;
        $this->conditions["max_len"] = 0;
    }

    public function setRequired()
    {
        $this->conditions["required"] = true;
    }

    public function setMinLen($min_len)
    {
        $this->conditions["min_len"] = $min_len;
    }

    public function setMaxLen($max_len)
    {
        $this->conditions["max_len"] = $max_len;
    }

    public function isValid()
    {
        $fail = function($error)
        {
            $this->error = $error;
            return false;
        };

        if($this->conditions["required"] === true and (trim($this->string) == "" or $this->string == null))
            return $fail($this->field_human_name . " must be filled in.");

        if($this->conditions["min_len"] !== 0 and strlen(trim($this->string)) < $this->conditions["min_len"])
            return $fail($this->field_human_name . " must be at least ".$this->conditions["min_len"]." characters long.");

        if($this->conditions["max_len"] !== 0 and strlen(trim($this->string)) > $this->conditions["max_len"])
            return $fail($this->field_human_name . " cannot exceed ".$this->conditions["max_len"]." characters in length.");

        return true;
    }

    public function getError()
    {
        return $this->error;
    }
}
?>
