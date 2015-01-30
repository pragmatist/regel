<?php

namespace Pragmatist\Regel\Tests\RuleSetProvider;

use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

final class InMemoryRuleSetProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateWithRuleSets()
    {
        $ruleSet = new ArrayRuleSet([]);
        $provider = new InMemoryRuleSetProvider(['test' => $ruleSet]);

        $this->assertSame(
            $ruleSet,
            $provider->ruleSetIdentifiedBy('test')
        );
    }

    /**
     * @test
     */
    public function itShouldAddRuleSets()
    {
        $ruleSet = new ArrayRuleSet([]);

        $provider = new InMemoryRuleSetProvider();
        $provider->addRuleSet('test', $ruleSet);

        $this->assertSame(
            $ruleSet,
            $provider->ruleSetIdentifiedBy('test')
        );
    }

    /**
     * @test
     */
    public function itShouldFailIfRuleSetDoesNotExist()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $provider = new InMemoryRuleSetProvider();
        $provider->ruleSetIdentifiedBy('test');
    }
}
