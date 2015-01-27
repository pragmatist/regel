<?php

namespace Pragmatist\Regel\Condition;

use Pragmatist\Regel\Subject\Subject;

interface Evaluator
{
    /**
     * @param Condition $condition
     * @param Subject $subject
     * @return bool
     */
    public function evaluate(Condition $condition, Subject $subject);
}
