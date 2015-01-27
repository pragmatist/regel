<?php

namespace Pragmatist\Regel\Tests\Engine;

use Mockery as m;
use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\Evaluator;
use Pragmatist\Regel\Condition\ExpressionLanguageCondition;
use Pragmatist\Regel\Context\ArrayContext;
use Pragmatist\Regel\Context\ContextFactory;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\Rule\ArrayRuleSet;
use Pragmatist\Regel\Tests\Fixtures\MyAction;
use Pragmatist\Regel\Tests\Fixtures\Ticket;
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
    private $contextFactory;

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
        $this->contextFactory = m::mock(ContextFactory::class);
        $this->actionExecutor = m::mock(ActionExecutor::class);

        $this->engine = new ActionEngine(
            $this->evaluator,
            $this->contextFactory,
            $this->actionExecutor
        );
    }

    /**
     * @test
     */
    public function itShouldApplyRuleToSubject()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $subject = new Ticket();
        $context = new ArrayContext(['foo' => 'bar']);

        $this->contextFactory->shouldReceive('createFromSubject')
            ->once()
            ->with($subject)
            ->andReturn($context);

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $context)
            ->andReturn(true);

        $this->actionExecutor->shouldReceive('execute')
            ->once()
            ->with($rule->getAction(), $context);

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
        $subject = new Ticket();
        $context = new ArrayContext(['foo' => 'bar']);

        $this->contextFactory->shouldReceive('createFromSubject')
            ->once()
            ->with($subject)
            ->andReturn($context);

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $context)
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
        $subject = new Ticket();
        $context = new ArrayContext(['foo' => 'bar']);

        $this->contextFactory->shouldReceive('createFromSubject')
            ->once()
            ->with($subject)
            ->andReturn($context);

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $context)
            ->andReturn(true);

        $this->actionExecutor->shouldReceive('execute')
            ->once()
            ->with($rule->getAction(), $context);

        $this->engine->applyRuleSetToSubject($ruleSet, $subject);
    }

    /**
     * @test
     */
    public function itShouldAbortIfRuleSetRuleEvaluatesToFalse()
    {
        $rule = new ActionableRule(new ExpressionLanguageCondition(new Expression('true')), new MyAction());
        $ruleSet = new ArrayRuleSet([$rule, $rule]);
        $subject = new Ticket();
        $context = new ArrayContext(['foo' => 'bar']);

        $this->contextFactory->shouldReceive('createFromSubject')
            ->once()
            ->with($subject)
            ->andReturn($context);

        $this->evaluator->shouldReceive('evaluate')
            ->once()
            ->with($rule->getCondition(), $context)
            ->andReturn(false);

        $this->actionExecutor->shouldReceive('execute')
            ->never();

        $this->engine->applyRuleSetToSubject($ruleSet, $subject);
    }
}
