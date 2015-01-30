<?php

namespace Pragmatist\Regel\RuleSetProvider;

use Pragmatist\Regel\RuleSet\RuleSet;

interface RuleSetProvider
{
    /**
     * @param $identifier
     * @return RuleSet
     */
    public function ruleSetIdentifiedBy($identifier);
}
