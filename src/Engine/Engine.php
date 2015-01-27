<?php

namespace Pragmatist\Regel\Engine;

use Pragmatist\Regel\Rule\Rule;
use Pragmatist\Regel\Rule\RuleSet;
use Pragmatist\Regel\Subject\Subject;

interface Engine
{
    /**
     * @param RuleSet $ruleSet
     * @param Subject $subject
     */
    public function applyRuleSetToSubject(RuleSet $ruleSet, Subject $subject);

    /**
     * @param Rule $rule
     * @param Subject $subject
     * @return bool
     */
    public function applyRuleToSubject(Rule $rule, Subject $subject);
}
