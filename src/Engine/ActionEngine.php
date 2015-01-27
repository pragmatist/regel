<?php

namespace Pragmatist\Regel\Engine;

use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\Evaluator;
use Pragmatist\Regel\Rule\Rule;
use Pragmatist\Regel\RuleSet\RuleSet;

final class ActionEngine implements Engine
{
    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @var ActionExecutor
     */
    private $actionExecutor;

    /**
     * @param Evaluator $evaluator
     * @param ActionExecutor $actionExecutor
     */
    public function __construct(Evaluator $evaluator, ActionExecutor $actionExecutor)
    {
        $this->evaluator = $evaluator;
        $this->actionExecutor = $actionExecutor;
    }

    /**
     * @param RuleSet $ruleSet
     * @param mixed $subject
     */
    public function applyRuleSetToSubject(RuleSet $ruleSet, $subject)
    {
        /** @var Rule $rule */
        foreach ($ruleSet as $rule) {
            if (!$this->applyRuleToSubject($rule, $subject)) {
                break;
            }
        }
    }

    /**
     * @param Rule $rule
     * @param mixed $subject
     * @return bool
     */
    public function applyRuleToSubject(Rule $rule, $subject)
    {
        if (!$this->evaluator->evaluate($rule->getCondition(), $subject)) {
            return false;
        }

        $this->actionExecutor->execute($rule->getAction(), $subject);
        return true;
    }
}
