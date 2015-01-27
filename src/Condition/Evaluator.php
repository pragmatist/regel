<?php

namespace Pragmatist\Regel\Condition;

interface Evaluator
{
    /**
     * @param Condition $condition
     * @param mixed $subject
     * @return bool
     */
    public function evaluate(Condition $condition, $subject);
}
