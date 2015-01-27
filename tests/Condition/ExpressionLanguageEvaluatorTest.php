<?php

namespace Pragmatist\Regel\Tests;

use Mockery as m;
use Pragmatist\Regel\Condition\ExpressionLanguageCondition;
use Pragmatist\Regel\Condition\ExpressionLanguageEvaluator;
use Pragmatist\Regel\Tests\Fixtures\TestSubject;
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
        $condition = ExpressionLanguageCondition::fromString('true');
        $subject = new TestSubject();

        $this->expressionLanguage->shouldReceive('evaluate')
            ->with($condition->getExpression(), ['foo' => 'bar'])
            ->andReturn(true);

        $this->assertTrue(
            $this->evaluator->evaluate($condition, $subject)
        );
    }
}
