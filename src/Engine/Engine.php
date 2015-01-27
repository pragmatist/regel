<?php

namespace Pragmatist\Regel\Engine;

use Pragmatist\Regel\Rule\Rule;
use Pragmatist\Regel\Rule\RuleSet;

interface Engine
{
    /**
     * @param RuleSet $ruleSet
     * @param mixed $subject
     */
    public function applyRuleSetToSubject(RuleSet $ruleSet, $subject);

    /**
     * @param Rule $rule
     * @param mixed $subject
     * @return bool
     */
    public function applyRuleToSubject(Rule $rule, $subject);
}
