<?php

namespace Pragmatist\Regel\Action;

interface ActionExecutor
{
    /**
     * @param Action $action
     * @param mixed $subject
     */
    public function execute(Action $action, $subject);
}
