<?php

namespace Pragmatist\Regel\Condition;

use Pragmatist\Regel\Context\Context;

interface Evaluator
{
    /**
     * @param Condition $condition
     * @param Context $context
     * @return bool
     */
    public function evaluate(Condition $condition, Context $context);
}
