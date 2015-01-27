<?php

namespace Pragmatist\Workflow\Tests\Engine;

use Mockery as m;
use Pragmatist\Workflow\Action\ActionExecutor;
use Pragmatist\Workflow\Condition\Evaluator;
use Pragmatist\Workflow\Condition\ExpressionLanguageCondition;
use Pragmatist\Workflow\Context\ArrayContext;
use Pragmatist\Workflow\Context\ContextFactory;
use Pragmatist\Workflow\Engine\ActionEngine;
use Pragmatist\Workflow\Rule\ActionableRule;
use Pragmatist\Workflow\Rule\ArrayRuleSet;
use Pragmatist\Workflow\Tests\Fixtures\MyAction;
use Pragmatist\Workflow\Tests\Fixtures\Ticket;
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
