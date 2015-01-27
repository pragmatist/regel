<?php

namespace Pragmatist\Regel\Action;

final class CallableActionExecutor implements ActionExecutor
{
    /**
     * @param Action $action
     * @param mixed $subject
     */
    public function execute(Action $action, $subject)
    {
        if (!is_callable($action)) {
            throw new \InvalidArgumentException('Provided action is not callable.');
        }

        $action($subject);
    }
}
