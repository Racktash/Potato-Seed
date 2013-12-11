<?php
class Validator
{
    protected $rules;
    protected $errors;
    protected $input_array;

    public function __construct($input_array)
    {
        $this->input_array = $input_array;
    }

    public function newRule($input_name, $field_human_name, $cond_str)
    {
        $new_rule = new Rule($this->input_array[$input_name], $field_human_name);
        $new_rule = $this->setConditions($new_rule, $cond_str);
        $this->rules[] = $new_rule;
    }

    public function setConditions($rule, $cond_str)
    {
        $conds = explode("|", $cond_str);

        if(in_array("required", $conds))
            $rule->setRequired();
       
        if(in_array("min_len", $conds))
        {
            $min_length_val = array_search("min_len", $conds) + 1;
            $rule->setMinLen($conds[$min_length_val]);
        }

        if(in_array("max_len", $conds))
        {
            $max_length_val = array_search("max_len", $conds) + 1;
            $rule->setMaxLen($conds[$max_length_val]);
        }

        return $rule;
    }

    public function allValid()
    {
        $pass = true;
        foreach($this->rules as $rule)
        {
            if(!$rule->isValid())
            {
                $this->errors[] = $rule->getError();
                $pass = false;
            }
        }

        return $pass;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
?>
