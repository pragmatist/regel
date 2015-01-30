---
currentMenu: condition_evaluators
---

# Creating condition evaluators

Conditions decide whether a given rule gets executed. Each condition type is handled by a specific condition evaluator.

If you want to create your own condition and evaluators, you simply need to implement the
`Pragmatist\Regel\Condition\Condition` and `Pragmatist\Regel\Condition\ConditionEvaluator` interfaces.

Let's create a condition type where we can use native PHP code as the condition.

First we need to create our condition.

```php
use Pragmatist\Regel\Condition\Condition;

final class NativeCodeCondition implements Condition
{
    private $nativeCode;

    public function __construct($nativeCode)
    {
        $this->nativeCode = $nativeCode;
    }
    
    public function __invoke($subject)
    {
        return eval($this->nativeCode);
    }
}
```

Our class takes the PHP code that needs to be executed as a constructor argument. We then use the `__invoke` method to
make our condition callable the moment when a subject needs to be evaluated. When it is called, the native code is
passed through the `eval()` function and its return value returned.

At this point we wouldn't have to write our own condition evaluator, as the `CallableConditionEvaluator` is able to
evaluate callable conditions. We're going to do so anyway to see how it could be done.

```php
use Pragmatist\Regel\Condition\ConditionEvaluator;

final class NativeCodeConditionEvaluator implements ConditionEvaluator
{
    public function evaluate(Condition $condition, $subject)
    {
        if (!$condition instanceof NativeCodeCondition) {
            throw new \LogicException('This evaluator only handles conditions of type NativeCodeCondition');
        }
        
        return (bool) $condition($subject);
    }
}
```

We only define a single function, which takes the condition and the subject. It calls the condition, and casts the
result of that to a boolean, which will determine if the condition has passed or not.

Now let's bring all of the above together and use our new native code condition.

```php
use Pragmatist\Regel\Action\CallableAction;
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

// Set up our RuleSet provider. Note that we use our custom NativeCodeCondition.
$ruleSetProvider = new InMemoryRuleSetProvider();
$ruleSetProvider->addRuleSet(
    'email-ruleset',
    new ArrayRuleSet(
        [
            new ActionableRule(
                new NativeCodeCondition('return (strpos($subject->body, "IMPORTANT") !== false);'),
                new CallableAction(
                    function ($subject) {
                        echo "E-mail '{$subject->subject}' is important!'\n";
                    }
                )
            )
        ]
    )
);

// Set up the RuleEngine with our own NativeCodeConditionEvaluator.
$engine = new ActionEngine(
    $ruleSetProvider,
    new NativeCodeConditionEvaluator(),
    new CallableActionExecutor()
);

// Define our subject, and run it through our rule engine
$emailMessage = new stdClass;
$emailMessage->subject = 'My message';
$emailMessage->body = 'Very IMPORTANT message!';

$engine->applyRuleSetToSubject('email-ruleset', $emailMessage);

// The above should output: E-mail 'My message' is important!
```
