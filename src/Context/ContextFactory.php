<?php

namespace Pragmatist\Workflow\Context;

use Pragmatist\Workflow\Subject\Subject;

interface ContextFactory
{
    /**
     * @param Subject $subject
     * @return Context
     */
    public function createFromSubject(Subject $subject);
}
