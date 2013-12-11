<?php
class Validator
{
    protected $rules;
    protected $errors;

    public function newRule($input_name, $field_human_name, $cond_str)
    {
        $new_rule = new Rule($input_name, $field_human_name);
    }

    public function setConditions($rule, $cond_str)
    {
        if(strpos($cond_str, 0) !== false)
        {
            $rule->setRequired();
        }
    }

    public function allValid($input_array);
    public function getErrors();
}
?>
