<?php

namespace Pragmatist\Regel\Action;

use Pragmatist\Regel\Subject\Subject;

final class CallableAction implements Action
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param Subject $subject
     */
    public function __invoke(Subject $subject)
    {
        call_user_func($this->callable, $subject);
    }
}
