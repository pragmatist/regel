<?php

namespace Pragmatist\Regel\Tests\Fixtures;

use Pragmatist\Regel\Subject\Subject;

final class Ticket implements Subject
{
    public $foo = 'bar';
    public $baz = 'fudge';
}
