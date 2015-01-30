<?php

namespace Pragmatist\Regel\Rule;

use Pragmatist\Regel\Action\Action;
use Pragmatist\Regel\Condition\Condition;

interface Rule
{
    /**
     * @return Condition
     */
    public function condition();

    /**
     * @return Action
     */
    public function action();
}
