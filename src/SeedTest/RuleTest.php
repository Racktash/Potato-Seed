<?php
require 'Seed/entities/Rule.php';

class RuleTest extends PHPUnit_Framework_TestCase
{
    public function testRequiredValid()
    {
        $rule = new Rule("The sleeping dog...", "Example Field");
        $rule->setRequired();
        $this->assertTrue($rule->isValid());
    }

    public function testRequiredInvalid()
    {
        $rule = new Rule("", "Example Field");
        $rule->setRequired();

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field must be filled in", $rule->getError());
    }

    public function testNoRulesAnythingValid()
    {
        $rule = new Rule("The sleeping dog...", "Example Field");
        $this->assertTrue($rule->isValid());

        $rule = new Rule("", "Example Field");
        $this->assertTrue($rule->isValid());
    }

    public function testMinValid()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMinLen(3);

        $this->assertTrue($rule->isValid());
    }

    public function testMinInvalid()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMinLen(4);

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field must be at least", $rule->getError());
    }

    public function testMaxValid()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMaxLen(3);

        $this->assertTrue($rule->isValid());
    }

    public function testMaxInvalid()
    {
        $rule = new Rule("Dog", "Example Field");
        $rule->setMaxLen(2);

        $this->assertFalse($rule->isValid());
        $this->assertContains("Example Field must not exceed", $rule->getError());
    }
}
?>
