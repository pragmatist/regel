<?php

namespace Pragmatist\Workflow\Rule;

use Pragmatist\Workflow\Action\Action;
use Pragmatist\Workflow\Condition\Condition;

interface Rule
{
    /**
     * @return Condition
     */
    public function getCondition();

    /**
     * @return Action
     */
    public function getAction();
}
