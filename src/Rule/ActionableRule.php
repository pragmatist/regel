<?php

namespace Pragmatist\Workflow\Rule;

use Pragmatist\Workflow\Action\Action;
use Pragmatist\Workflow\Condition\Condition;

final class ActionableRule implements Rule
{
    /**
     * @var Condition
     */
    private $condition;

    /**
     * @var Action
     */
    private $action;

    /**
     * @param Condition $condition
     * @param Action $action
     */
    public function __construct(Condition $condition, Action $action)
    {
        $this->condition = $condition;
        $this->action = $action;
    }

    /**
     * @return Condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return Action
     */
    public function getAction()
    {
        return $this->action;
    }
}
