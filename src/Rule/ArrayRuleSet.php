<?php

namespace Pragmatist\Regel\Rule;

final class ArrayRuleSet implements RuleSet
{
    /**
     * @var Rule[]
     */
    private $rules = [];

    /**
     * @param Rule[] $rules
     */
    public function __construct(array $rules)
    {
        foreach ($rules as $rule) {
            if (!$rule instanceof Rule) {
                throw new \InvalidArgumentException("Expected a Rule");
            }
            $this->rules[] = $rule;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->rules);
    }

    /**
     * @return Rule
     */
    public function current()
    {
        return current($this->rules);
    }

    /**
     * @return int
     */
    public function key()
    {
        return key($this->rules);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->rules);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->rules);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return null !== key($this->rules);
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return null !== $this->rules[$offset];
    }

    /**
     * @param int $offset
     * @return Rule
     */
    public function offsetGet($offset)
    {
        return $this->rules[$offset];
    }

    /**
     * @param int $offset
     * @param Rule $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Rule) {
            throw new \InvalidArgumentException("Expected a Rule");
        }

        $this->rules[$offset] = $value;
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->rules[$offset]);
    }
}
