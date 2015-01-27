<?php

namespace Pragmatist\Regel\Engine;

interface Engine
{
    /**
     * @param string $ruleSetIdentifier
     * @param mixed $subject
     */
    public function applyRuleSetToSubject($ruleSetIdentifier, $subject);
}
