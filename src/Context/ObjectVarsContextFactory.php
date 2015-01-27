<?php

namespace Pragmatist\Workflow\Context;

use Pragmatist\Workflow\Subject\Subject;

final class ObjectVarsContextFactory implements ContextFactory
{
    /**
     * @param Subject $subject
     * @return Context
     */
    public function createFromSubject(Subject $subject)
    {
        return new ArrayContext(get_object_vars($subject));
    }
}
