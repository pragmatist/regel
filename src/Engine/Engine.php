<?php

namespace Pragmatist\Workflow\Engine;

use Pragmatist\Workflow\Rule\Rule;
use Pragmatist\Workflow\Rule\RuleSet;
use Pragmatist\Workflow\Subject\Subject;

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
