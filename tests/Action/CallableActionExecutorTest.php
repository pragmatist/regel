<?php

namespace Pragmatist\Regel\Tests\Action;

use Pragmatist\Regel\Action\CallableAction;
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Subject\Subject;
use Pragmatist\Regel\Tests\Fixtures\NonCallableAction;
use Pragmatist\Regel\Tests\Fixtures\TestSubject;

final class CallableActionExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallableActionExecutor
     */
    private $actionExecutor;

    public function setUp()
    {
        $this->actionExecutor = new CallableActionExecutor();
    }

    /**
     * @test
     */
    public function itShouldExecuteCallableActions()
    {
        $actionExecuted = false;

        $subject = new TestSubject();
        $this->actionExecutor->execute(
            new CallableAction(
                function (Subject $givenSubject) use (&$actionExecuted, $subject) {
                    $this->assertSame($subject, $givenSubject);
                    $actionExecuted = true;
                }
            ),
            $subject
        );

        $this->assertTrue($actionExecuted);
    }

    /**
     * @test
     */
    public function itShouldFailWhenNonCallableActionsArePassed()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->actionExecutor->execute(new NonCallableAction(), new TestSubject());
    }
}
