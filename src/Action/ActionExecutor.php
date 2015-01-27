<?php

namespace Pragmatist\Regel\Action;

use Pragmatist\Regel\Subject\Subject;

interface ActionExecutor
{
    /**
     * @param Action $action
     * @param Subject $context
     */
    public function execute(Action $action, Subject $context);
}
