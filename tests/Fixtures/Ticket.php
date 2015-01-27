<?php

namespace Pragmatist\Workflow\Tests\Fixtures;

use Pragmatist\Workflow\Subject\Subject;

final class Ticket implements Subject
{
    public $foo = 'bar';
    public $baz = 'fudge';
}
