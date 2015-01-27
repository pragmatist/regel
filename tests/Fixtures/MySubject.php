<?php

namespace Pragmatist\Regel\Tests\Fixtures;

use Pragmatist\Regel\Subject\Subject;

final class MySubject implements Subject
{
    /**
     * @return array
     */
    public function toArray()
    {
        return ['foo' => 'bar'];
    }

}
