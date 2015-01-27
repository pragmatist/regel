<?php

namespace Pragmatist\Workflow\Tests\Context;

use Pragmatist\Workflow\Context\ObjectVarsContextFactory;
use Pragmatist\Workflow\Tests\Fixtures\Ticket;

final class ObjectVarsContextFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectVarsContextFactory
     */
    private $contextFactory;

    public function setUp()
    {
        $this->contextFactory = new ObjectVarsContextFactory();
    }

    /**
     * @test
     */
    public function itShouldCreateAContext()
    {
        $subject = new Ticket();
        $context = $this->contextFactory->createFromSubject($subject);

        $this->assertEquals(
            ['foo' => 'bar', 'baz' => 'fudge'],
            $context->toArray()
        );
    }
}
