<?php
require_once 'Seed/entities/Rule.php';
require_once 'Seed/entities/Validator.php';

class validatorTest extends PHPUnit_Framework_TestCase
{
    public function test_newRuleRequired_NullInput_ReturnsFalseAndError()
    {
        $test_input["field"] = null;
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must be filled in", $errors[0]);
    }

    public function test_newRuleRequired_EmptyStringInput_ReturnsFalseAndError()
    {
        $test_input["field"] = "";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must be filled in", $errors[0]);
    }

    public function test_newRuleRequired_NoRelevantInput_ReturnsException()
    {
        $test_input["some_other_field"] = "";
        $validator = new Validator($test_input);

        try
        {
            $validator->newRule("field", "Field", "required");
            $this->fail("No exception generated!");
        }
        catch(Exception $e)
        {
            $this->assertEquals($e->getMessage(), "Input not supplied!");
        }
    }

    public function test_newRuleRequired_ValidInput_ReturnsTrue()
    {
        $test_input["field"] = "Perfectly valid value";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertTrue($validator->allValid());
    }

    public function test_newRuleMinLen_InputBelowMin_ReturnsFalseAndError()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "min_len|6");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must be at least", $errors[0]);
        $this->assertContains("6", $errors[0]);
    }

    public function test_newRuleMinLen_ExactlyMin_ReturnsTrue()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "min_len|5");
        
        $this->assertTrue($validator->allValid());
    }

    public function test_newRuleMinLen_InputAboveMin_ReturnTrue()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "min_len|2");
        
        $this->assertTrue($validator->allValid());
    }

    public function test_newRuleMaxLen_InputAboveMax_ReturnsFalseAndError()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must not exceed", $errors[0]);
        $this->assertContains("4", $errors[0]);
    }

    public function test_newRuleMaxLen_InputExactMax_ReturnsTrue()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "max_len|5");
        
        $this->assertTrue($validator->allValid());
    }

    public function test_newRuleMaxLen_InputBelowMax_ReturnsTrue()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "max_len|6");
        
        $this->assertTrue($validator->allValid());
    }

    public function test_MultipleRules_ViolateMaxLen_ReturnsFalseAndError()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required|min_len|2|max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("must not exceed", $errors[0]);
    }

    public function test_MultipleRules_ViolateMinLen_ReturnsFalseAndError()
    {
        $test_input["field"] = "W";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required|min_len|2|max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("must be at least", $errors[0]);
    }

    public function test_MultipleRules_ViolateRequired_ReturnsFalseAndError()
    {
        $test_input["field"] = "";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required|min_len|2|max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("must be filled in", $errors[0]);
    }
}
?>
