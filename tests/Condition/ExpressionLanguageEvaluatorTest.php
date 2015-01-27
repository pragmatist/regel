<?php

namespace Pragmatist\Regel\Tests;

use Mockery as m;
use Pragmatist\Regel\Condition\ExpressionLanguageCondition;
use Pragmatist\Regel\Condition\ExpressionLanguageEvaluator;
use Pragmatist\Regel\Tests\Fixtures\TestSubject;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

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
        $condition = ExpressionLanguageCondition::fromString('true');
        $subject = new TestSubject();

        $this->expressionLanguage->shouldReceive('evaluate')
            ->with($condition->getExpression(), ['subject' => $subject])
            ->andReturn(true);

        $this->assertTrue(
            $this->evaluator->evaluate($condition, $subject)
        );
    }

    /**
     * @test
     */
    public function itShouldReturnFalseOnSyntaxError()
    {
        $condition = ExpressionLanguageCondition::fromString('very invalid');
        $subject = new TestSubject();

        $this->expressionLanguage->shouldReceive('evaluate')
            ->with($condition->getExpression(), ['subject' => $subject])
            ->andThrow(SyntaxError::class);

        $this->assertFalse(
            $this->evaluator->evaluate($condition, $subject)
        );
    }
}
