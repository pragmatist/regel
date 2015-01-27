<?php

namespace Pragmatist\Workflow\Engine;

use Pragmatist\Workflow\Action\ActionExecutor;
use Pragmatist\Workflow\Condition\Evaluator;
use Pragmatist\Workflow\Context\ContextFactory;
use Pragmatist\Workflow\Rule\Rule;
use Pragmatist\Workflow\Rule\RuleSet;
use Pragmatist\Workflow\Subject\Subject;

final class ActionEngine implements Engine
{
    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @var ContextFactory
     */
    private $contextFactory;

    /**
     * @var ActionExecutor
     */
    private $actionExecutor;

    /**
     * @param Evaluator $evaluator
     * @param ContextFactory $contextFactory
     * @param ActionExecutor $actionExecutor
     */
    public function __construct(Evaluator $evaluator, ContextFactory $contextFactory, ActionExecutor $actionExecutor)
    {
        $this->evaluator = $evaluator;
        $this->contextFactory = $contextFactory;
        $this->actionExecutor = $actionExecutor;
    }

    /**
     * @param RuleSet $ruleSet
     * @param Subject $subject
     */
    public function applyRuleSetToSubject(RuleSet $ruleSet, Subject $subject)
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
     * @param Subject $subject
     * @return bool
     */
    public function applyRuleToSubject(Rule $rule, Subject $subject)
    {
        $context = $this->contextFactory->createFromSubject($subject);

        if (!$this->evaluator->evaluate($rule->getCondition(), $context)) {
            return false;
        }

        $this->actionExecutor->execute($rule->getAction(), $context);
        return true;
    }
}
