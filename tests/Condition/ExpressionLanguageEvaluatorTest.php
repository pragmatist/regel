<?php

namespace Pragmatist\Workflow\Tests;

use Mockery as m;
use Pragmatist\Workflow\Condition\ExpressionLanguageCondition;
use Pragmatist\Workflow\Condition\ExpressionLanguageEvaluator;
use Pragmatist\Workflow\Context\ArrayContext;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class ExpressionLanguageEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $expressionLanguage;

    /**
     * @var ExpressionLanguageEvaluator
     */
    private $evaluator;

    public function setUp()
    {
        $this->expressionLanguage = m::mock(ExpressionLanguage::class);
        $this->evaluator = new ExpressionLanguageEvaluator($this->expressionLanguage);
    }

    /**
     * @test
     */
    public function itShouldEvaluate()
    {
        $expression = new Expression('true');
        $condition = new ExpressionLanguageCondition($expression);
        $context = new ArrayContext(['foo' => 'bar']);

        $this->expressionLanguage->shouldReceive('evaluate')
            ->with($expression, ['foo' => 'bar'])
            ->andReturn(true);

        $this->assertTrue(
            $this->evaluator->evaluate($condition, $context)
        );
    }
}
