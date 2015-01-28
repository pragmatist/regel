<?php

require __DIR__ . '/../vendor/autoload.php';

use Pragmatist\Regel\Action\CallableAction;
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Condition\CallableCondition;
use Pragmatist\Regel\Condition\CallableEvaluator;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

// Our example domain object
class EmailMessage
{
    public $subject = 'My message';
    public $body = 'My very IMPORTANT message';
}


// Set up our RuleSet provider. Normally in your DI container.
$ruleSetProvider = new InMemoryRuleSetProvider();
$ruleSetProvider->addRuleSet(
    'email-ruleset',
    new ArrayRuleSet(
        [
            new ActionableRule(
                new CallableCondition(function($subject) { return preg_match('/important/i', $subject->body); }),
                new CallableAction(
                    function ($subject) {
                        echo "E-mail '{$subject->subject}' is important!'\n";
                    }
                )
            )
        ]
    )
);


// Set up the RuleEngine. Also normally in your DI container.
$engine = new ActionEngine(
    $ruleSetProvider,
    new CallableEvaluator(),
    new CallableActionExecutor()
);


// Apply the ruleset to a subject
$subject = new EmailMessage();
$engine->applyRuleSetToSubject('email-ruleset', $subject);
