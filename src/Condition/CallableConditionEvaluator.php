<?php

namespace Pragmatist\Regel\Condition;

final class CallableConditionEvaluator implements ConditionEvaluator
{
    /**
     * @param Condition $condition
     * @param mixed $subject
     * @return bool
     */
    public function evaluate(Condition $condition, $subject)
    {
        if (!is_callable($condition)) {
            throw new \InvalidArgumentException('Condition must be callable.');
        }

        return (bool) $condition($subject);
    }
}
