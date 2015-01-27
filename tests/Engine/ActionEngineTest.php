<?php

namespace Pragmatist\Regel\Tests\Engine;

use Mockery as m;
use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\Evaluator;
use Pragmatist\Regel\Condition\ExpressionLanguageCondition;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\Rule\ArrayRuleSet;
use Pragmatist\Regel\Tests\Fixtures\MyAction;
use Pragmatist\Regel\Tests\Fixtures\MySubject;
use Symfony\Component\ExpressionLanguage\Expression;

final class ActionEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $evaluator;

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
        $this->evaluator = m::mock(Evaluator::class);
        $this->actionExecutor = m::mock(ActionExecutor::class);

        $this->engine = new ActionEngine(
            $this->evaluator,
            $this->actionExecutor
        );
    }

    /**
     * @test
     */
    public function itShouldApplyRuleToSubject()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $subject = new MySubject();

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(true);

        $this->actionExecutor->shouldReceive('execute')
            ->once()
            ->with($rule->getAction(), $subject);

        $this->assertTrue(
            $this->engine->applyRuleToSubject($rule, $subject)
        );
    }

    /**
     * @test
     */
    public function itShouldNotExecuteActionIfRuleConditionEvaluatesToFalse()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $subject = new MySubject();

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(false);

        $this->actionExecutor->shouldReceive('execute')
            ->never();

        $this->assertFalse(
            $this->engine->applyRuleToSubject($rule, $subject)
        );
    }

    /**
     * @test
     */
    public function itShouldApplyRuleSetToSubject()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule]);
        $subject = new MySubject();

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(true);

        $this->actionExecutor->shouldReceive('execute')
            ->once()
            ->with($rule->getAction(), $subject);

        $this->engine->applyRuleSetToSubject($ruleSet, $subject);
    }

    /**
     * @test
     */
    public function itShouldAbortIfRuleSetRuleEvaluatesToFalse()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule, $rule]);
        $subject = new MySubject();

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $subject)
            ->andReturn(false);

        $this->actionExecutor->shouldReceive('execute')
            ->never();

        $this->engine->applyRuleSetToSubject($ruleSet, $subject);
    }
}
