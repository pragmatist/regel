<?php

namespace Pragmatist\Regel\Tests\Condition;

use Mockery as m;
use Pragmatist\Regel\Condition\CallableCondition;
use Pragmatist\Regel\Condition\CallableConditionEvaluator;
use Pragmatist\Regel\Condition\Condition;

final class CallableConditionEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallableConditionEvaluator
     */
    private $evaluator;

    public function setUp()
    {
        $this->evaluator = new CallableConditionEvaluator();
    }

    /**
     * @test
     */
    public function itShouldEvaluateCallables()
    {
        $this->assertTrue(
            $this->evaluator->evaluate(
                new CallableCondition(
                    function($subject) {
                        return ($subject == 'foo');
                    }
                ),
                'foo'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldCastCallableReturnValuesToBooleans()
    {
        $this->assertTrue(
            $this->evaluator->evaluate(
                new CallableCondition(
                    function($subject) {
                        return $subject;
                    }
                ),
                'foo'
            )
        );

        $this->assertFalse(
            $this->evaluator->evaluate(
                new CallableCondition(
                    function($subject) {
                        return $subject;
                    }
                ),
                0
            )
        );
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfNoCallableIsProvided()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->evaluator->evaluate(m::mock(Condition::class), 'foo');
    }
}
