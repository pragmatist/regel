<?php

namespace Pragmatist\Regel\Action;

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
     * @param mixed $subject
     */
    public function __invoke($subject)
    {
        call_user_func($this->callable, $subject);
    }
}
