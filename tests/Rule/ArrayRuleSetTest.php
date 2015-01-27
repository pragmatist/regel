<?php

namespace Pragmatist\Regel\Tests\Rule;

use Pragmatist\Regel\Condition\ExpressionLanguageCondition;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\Rule\ArrayRuleSet;
use Pragmatist\Regel\Tests\Fixtures\MyAction;
use Symfony\Component\ExpressionLanguage\Expression;

final class ArrayRuleSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateWithRules()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule]);
        $this->assertArrayHasKey(0, $ruleSet);
        $this->assertEquals($rule, $ruleSet[0]);
        $this->assertCount(1, $ruleSet);
    }

    /**
     * @test
     */
    public function itShouldFailWhenInstantiatedWithInvalidValues()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new ArrayRuleSet(['foo', 'bar']);
    }

    /**
     * @test
     */
    public function itShouldSetRules()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([]);
        $ruleSet[0] = $rule;
        $this->assertArrayHasKey(0, $ruleSet);
        $this->assertEquals($rule, $ruleSet[0]);
        $this->assertCount(1, $ruleSet);
    }

    /**
     * @test
     */
    public function itShouldFailWhenSettingAnInvalidRule()
    {
        $ruleSet = new ArrayRuleSet([]);

        $this->setExpectedException(\InvalidArgumentException::class);
        $ruleSet[0] = 'foo';
    }

    /**
     * @test
     */
    public function itShouldBeTraversable()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule]);

        foreach ($ruleSet as $key => $ruleSetRule) {
            $this->assertEquals(0, $key);
            $this->assertEquals($rule, $ruleSetRule);
        }
    }

    /**
     * @test
     */
    public function itShouldUnsetRules()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule]);

        unset($ruleSet[0]);

        $this->assertCount(0, $ruleSet);
    }
}
