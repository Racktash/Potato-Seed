<?php
require_once 'Seed/entities/Rule.php';
require_once 'Seed/entities/Validator.php';

class validatorTest extends PHPUnit_Framework_TestCase
{
    public function testRequiredNullStringReject()
    {
        $test_input["field"] = null;
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must be filled in", $errors[0]);
    }

    public function testRequiredEmptyStringReject()
    {
        $test_input["field"] = "";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("Field", $errors[0]);
        $this->assertContains("must be filled in", $errors[0]);
    }

    public function testRequiredNoValueReject()
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

    public function testRequiredNotEmptyStringAccept()
    {
        $test_input["field"] = "Perfectly valid value";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required");
        
        $this->assertTrue($validator->allValid());
    }

    public function testMinLenBelowReject()
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

    public function testMinLenExactAccept()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "min_len|5");
        
        $this->assertTrue($validator->allValid());
    }

    public function testMinLenAboveAccept()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "min_len|2");
        
        $this->assertTrue($validator->allValid());
    }

    public function testMaxLenAboveReject()
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

    public function testMaxLenExactAccept()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "max_len|5");
        
        $this->assertTrue($validator->allValid());
    }

    public function testMaxLenBelowAccept()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "max_len|6");
        
        $this->assertTrue($validator->allValid());
    }

    public function testMultipleInvalidMaxLenReject()
    {
        $test_input["field"] = "Small";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required|min_len|2|max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("must not exceed", $errors[0]);
    }

    public function testMultipleInvalidMinLenReject()
    {
        $test_input["field"] = "W";
        $validator = new Validator($test_input);

        $validator->newRule("field", "Field", "required|min_len|2|max_len|4");
        
        $this->assertFalse($validator->allValid());
        $errors = $validator->getErrors();

        $this->assertContains("must be at least", $errors[0]);
    }

    public function testMultipleInvalidRequiredReject()
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
