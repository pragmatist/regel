<?php

namespace Pragmatist\Regel\RuleSetProvider;

use Pragmatist\Regel\RuleSet\RuleSet;

final class InMemoryRuleSetProvider implements RuleSetProvider
{
    /**
     * @var array
     */
    private $ruleSets = [];

    /**
     * @param array $ruleSets
     */
    public function __construct(array $ruleSets = [])
    {
        foreach ($ruleSets as $identifier => $ruleSet) {
            $this->addRuleSet($identifier, $ruleSet);
        }
    }

    /**
     * @param string $identifier
     * @param RuleSet $ruleSet
     */
    public function addRuleSet($identifier, RuleSet $ruleSet)
    {
        $this->ruleSets[$identifier] = $ruleSet;
    }

    /**
     * @param string $identifier
     * @return RuleSet
     * @throws \InvalidArgumentException
     */
    public function ruleSetIdentifiedBy($identifier)
    {
        if (array_key_exists($identifier, $this->ruleSets)) {
            return $this->ruleSets[$identifier];
        }

        throw new \InvalidArgumentException('No rule set with that identifier is available.');
    }
}
