<?php

namespace Pragmatist\Workflow\Action;

use Pragmatist\Workflow\Context\Context;

interface ActionExecutor
{
    /**
     * @param Action $action
     * @param Context $context
     */
    public function execute(Action $action, Context $context);
}
