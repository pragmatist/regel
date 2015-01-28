<?php

namespace Pragmatist\Regel\Condition;

interface ConditionEvaluator
{
    /**
     * @param Condition $condition
     * @param mixed $subject
     * @return bool
     */
    public function evaluate(Condition $condition, $subject);
}
