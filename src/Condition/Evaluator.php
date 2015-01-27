<?php

namespace Pragmatist\Workflow\Condition;

use Pragmatist\Workflow\Context\Context;

interface Evaluator
{
    /**
     * @param Condition $condition
     * @param Context $context
     * @return bool
     */
    public function evaluate(Condition $condition, Context $context);
}
