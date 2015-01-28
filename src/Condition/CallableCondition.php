<?php

namespace Pragmatist\Regel\Condition;

final class CallableCondition implements Condition
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
     * @return bool
     */
    public function __invoke()
    {
        return call_user_func_array($this->callable, func_get_args());
    }
}
