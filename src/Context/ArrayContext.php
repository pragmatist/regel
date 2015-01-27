<?php

namespace Pragmatist\Regel\Context;

final class ArrayContext implements Context
{
    /**
     * @var array
     */
    private $payload = [];

    /**
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }
}
