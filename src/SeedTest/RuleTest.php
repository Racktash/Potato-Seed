<?php
require_once 'Seed/entities/Rule.php';

class RuleTest extends PHPUnit_Framework_TestCase
{
    public function test_setRequired_ValidString_ReturnsTrue()
    {
        $rule = new Rule("The sleeping dog...", "Example Field");
        $rule->setRequired();
        $this->assertTrue($rule->isValid());
    }

    public function test_setRequired_InvalidString_ReturnsFalseAndError()
    {
        $rule = new Rule("", "Example Field");
        $rule->setRequired();

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field must be filled in", $rule->getError());
    }

    public function test_noRules_EmptyString_ReturnsTrue()
    {
        $rule = new Rule("", "Example Field");
        $this->assertTrue($rule->isValid());
    }

    public function test_noRules_ValidString_ReturnsTrue()
    {
        $rule = new Rule("Some string", "Example Field");
        $this->assertTrue($rule->isValid());
    }

    public function test_setMinLen_ValidString_ReturnsTrue()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMinLen(3);

        $this->assertTrue($rule->isValid());
    }

    public function test_setMinLen_InvalidString_ReturnsFalseAndError()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMinLen(4);

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field must be at least", $rule->getError());
    }

    public function test_setMaxLen_ValidString_ReturnsTrue()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMaxLen(3);

        $this->assertTrue($rule->isValid());
    }

    public function test_setMaxLen_InvalidString_ReturnsFalseAndError()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMaxLen(2);

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field cannot exceed", $rule->getError());
    }
}
?>
