<?php

namespace Pragmatist\Workflow\Condition;

interface Condition
{
    /**
     * @return mixed
     */
    public function getExpression();
}
