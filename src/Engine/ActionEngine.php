<?php

namespace Pragmatist\Regel\Engine;

use Pragmatist\Regel\Action\ActionExecutor;
use Pragmatist\Regel\Condition\Evaluator;
use Pragmatist\Regel\Rule\Rule;
use Pragmatist\Regel\RuleSetProvider\RuleSetProvider;

final class ActionEngine implements Engine
{
    /**
     * @var RuleSetProvider
     */
    private $ruleSetProvider;

    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @var ActionExecutor
     */
    private $actionExecutor;

    /**
     * @param RuleSetProvider $ruleSetProvider
     * @param Evaluator $evaluator
     * @param ActionExecutor $actionExecutor
     */
    public function __construct(RuleSetProvider $ruleSetProvider, Evaluator $evaluator, ActionExecutor $actionExecutor)
    {
        $this->ruleSetProvider = $ruleSetProvider;
        $this->evaluator = $evaluator;
        $this->actionExecutor = $actionExecutor;
    }

    /**
     * @param string $ruleSetIdentifier
     * @param mixed $subject
     */
    public function applyRuleSetToSubject($ruleSetIdentifier, $subject)
    {
        $ruleSet = $this->ruleSetProvider->getRuleSetIdentifiedBy($ruleSetIdentifier);
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
    private function applyRuleToSubject(Rule $rule, $subject)
    {
        if (!$this->evaluator->evaluate($rule->getCondition(), $subject)) {
            return false;
        }

        $this->actionExecutor->execute($rule->getAction(), $subject);
        return true;
    }
}
