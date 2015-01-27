<?php

namespace Pragmatist\Regel\Action;

use Pragmatist\Regel\Context\Context;

interface ActionExecutor
{
    /**
     * @param Action $action
     * @param Context $context
     */
    public function execute(Action $action, Context $context);
}
