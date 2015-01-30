---
currentMenu: getting_started
---

# Getting started

## Installation

Using [Composer](https://getcomposer.org/):

```bash
composer require pragmatist/regel
```

## Defining your rules

Your business rules are what it's all about. A rule always has a condition and an action. When the condition matches the
subject, your action is executed.

If we use the built in callback condition and action types, you can define a rule as follows:

```php
use Pragmatist\Regel\Condition\CallableCondition;
use Pragmatist\Regel\Action\CallableAction;
use Pragmatist\Regel\Rule\ActionableRule;

$rule = new ActionableRule(
    new CallableCondition(function($subject) { return preg_match('/important/i', $subject->body); }),
    new CallableAction(
        function ($subject) {
            echo "E-mail '{$subject->subject}' is important!'\n";
        }
    )
)
```

In the above example we instantiate an instance of the ActionableRule class, which represents our rule. It takes two
constructor arguments; the condition and the action. The condition in this case is a callback, which takes the subject
our rule applies to as its only parameter. The action is also a callback, which can be whatever you need to execute
if the rule matches.

This in itself is less useful, but illustrates well what Regel's basic rule structure is. The real power of Regel starts
to show when you define your own condition and action types, as shown in a later section of the documentation.

## Using rule sets

A single rule on its own doesn't do that much. We can combine multiple rules into rule sets, which can be executed
sequentually on a given subject. In order for us to use rule sets in our rule engine, we have to define a so called
rule set provider. The rule set provider is responsible for providing rule sets to the engine. We can define a rule set
provider as follows.

```php
use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

$ruleSetProvider = new InMemoryRuleSetProvider();
$ruleSetProvider->addRuleSet(
    'email-ruleset',
    new ArrayRuleSet(
        [$rule, $anotherRule]
    )
);
```

In this case we are using the in memory rule set provider, which requires us to pass the rule sets directly. We simply
define a new rule set and pass in the rules as instantiated earlier. Note that we also define a name for our rule set.
This is important when deciding what rule set to apply on our subject later.

## Using the rule engine

Now that we have defined our rule set and a provider, we can instantiate the rule engine itself. We do that as follows.

```php
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Condition\CallableConditionEvaluator;
use Pragmatist\Regel\Engine\ActionEngine;

$engine = new ActionEngine(
    $ruleSetProvider,
    new CallableConditionEvaluator(),
    new CallableActionExecutor()
);
```

Here we pass in the rule set provider we defined earlier. We are also passing in two other components, the condition
evaluator and the action executor. The condition evaluator knows how to evaluate conditions of a specific type (in this
case the callable condition), while the action executor knows how to handle actions of a specific type (the callable
action).

All of these components are interchangable with your own components, as long as they implement the correct interfaces.
More about this in the section on extending Regel.

The next step is actually applying our ruleset to a given subject. We do that as follows.

```php
$subject = new MyEmailMessage();
$engine->applyRuleSetToSubject('email-ruleset', $subject);
```

This will retrieve the "email-ruleset" rule set from the rule set provider, and then evaluate all rule conditions
sequentually, give the subject. When a certain rule's condition evaluates to true, it will execute that rule's action.
