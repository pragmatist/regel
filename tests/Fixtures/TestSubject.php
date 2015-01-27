<?php

namespace Pragmatist\Regel\Tests\Fixtures;

use Pragmatist\Regel\Subject\Subject;

final class TestSubject implements Subject
{
    /**
     * @return array
     */
    public function toArray()
    {
        return ['foo' => 'bar'];
    }

}
