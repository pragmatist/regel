<?php

namespace Pragmatist\Regel\Action;

use Pragmatist\Regel\Subject\Subject;

final class CallableActionExecutor implements ActionExecutor
{
    /**
     * @param Action $action
     * @param Subject $subject
     */
    public function execute(Action $action, Subject $subject)
    {
        if (!is_callable($action)) {
            throw new \InvalidArgumentException('Provided action is not callable.');
        }

        $action($subject);
    }
}
