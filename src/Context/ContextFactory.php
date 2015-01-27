<?php

namespace Pragmatist\Regel\Context;

use Pragmatist\Regel\Subject\Subject;

interface ContextFactory
{
    /**
     * @param Subject $subject
     * @return Context
     */
    public function createFromSubject(Subject $subject);
}
