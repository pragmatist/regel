# Regel

[![Build Status](https://travis-ci.org/Pragmatist/Regel.svg)](https://travis-ci.org/Pragmatist/Regel)
[![Build Status](https://scrutinizer-ci.com/g/Pragmatist/Regel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Pragmatist/Regel/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Pragmatist/Regel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Pragmatist/Regel/?branch=master)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/Pragmatist/Regel/blob/master/LICENSE)

Regel is a simple business rules engine for PHP 5.5+. It allows you apply dynamically created rules on your domain objects.

This project is still very much under development. Things will most likely change, so use at your own risk.

## Installation

Using composer:

    composer require pragmatist/regel


## Quick example

We have an application that imports e-mail messages. Based on the message, we want to perform an action.

First we define our domain object:

```php
class EmailMessage
{
    public $fromAddress = 'foo@example.com';
    public $body = 'My very IMPORTANT message';
}
```

Then we instantiate the rule engine. We will be using the Symfony Expression language component to evaluate conditions.

```php
$engine = new ActionEngine(
    new ExpressionLanguageEvaluator(new ExpressionLanguage()),
    new CallableActionExecutor()
);
```

We then create our rule set containing two rules. Each of the rules has a condition and an action. If the condition evaluates to `true`, the action is executed.

```php
$ruleSet = new ArrayRuleSet(
    [
        new ActionableRule(
            ExpressionLanguageCondition::fromString("subject.fromAddress == 'foo@example.com'"),
            new CallableAction(
                function ($subject) {
                    echo "Message is from foo@example.com!\n";
                }
            )
        ),
        new ActionableRule(
            ExpressionLanguageCondition::fromString("subject.body matches '/IMPORTANT/'"),
            new CallableAction(
                function ($subject) {
                    echo "Message is very important!\n";
                }
            )
        )
    ]
);
```

Now we can apply the rule set to the message:

```php
$engine->applyRuleSetToSubject($ruleSet, new EmailMessage());

```
