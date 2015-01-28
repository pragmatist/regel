<?php

namespace Pragmatist\Regel\Tests\Engine;

use Mockery as m;
use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\CallableCondition;
use Pragmatist\Regel\Condition\ConditionEvaluator;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\RuleSetProvider;
use Pragmatist\Regel\Tests\Fixtures\NonCallableAction;
use Pragmatist\Regel\Tests\Fixtures\TestSubject;

final class ActionEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $ruleSetProvider;

    /**
     * @var \Mockery\MockInterface
     */
    private $conditionEvaluator;

    /**
     * @var \Mockery\MockInterface
     */
    private $actionExecutor;

    /**
     * @var ActionEngine
     */
    private $engine;

    public function setUp()
    {
        $this->ruleSetProvider = m::mock(RuleSetProvider::class);
        $this->conditionEvaluator = m::mock(ConditionEvaluator::class);
        $this->actionExecutor = m::mock(ActionExecutor::class);

        $this->engine = new ActionEngine(
            $this->ruleSetProvider,
            $this->conditionEvaluator,
            $this->actionExecutor
        );
    }

    /**
     * @test
     */
    public function itShouldApplyRuleSetToSubject()
    {
        $rule = new ActionableRule(
            new CallableCondition(
                function () {
                    return true;
                }
            ),
            new NonCallableAction()
        );
        $ruleSet = new ArrayRuleSet([$rule]);
        $subject = new TestSubject();

        $this->ruleSetProvider->shouldReceive('getRuleSetIdentifiedBy')
            ->once()
            ->with('testRuleSet')
            ->andReturn($ruleSet);

        $this->conditionEvaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(true);

        $this->actionExecutor->shouldReceive('execute')
            ->once()
            ->with($rule->getAction(), $subject);

        $this->engine->applyRuleSetToSubject('testRuleSet', $subject);
    }

    /**
     * @test
     */
    public function itShouldAbortIfRuleSetRuleEvaluatesToFalse()
    {
        $rule = new ActionableRule(
            new CallableCondition(
                function () {
                    return true;
                }
            ),
            new NonCallableAction()
        );
        $ruleSet = new ArrayRuleSet([$rule, $rule]);
        $subject = new TestSubject();

        $this->ruleSetProvider->shouldReceive('getRuleSetIdentifiedBy')
            ->once()
            ->with('testRuleSet')
            ->andReturn($ruleSet);

        $this->conditionEvaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(false);

        $this->actionExecutor->shouldReceive('execute')
            ->never();

        $this->engine->applyRuleSetToSubject('testRuleSet', $subject);
    }
}
