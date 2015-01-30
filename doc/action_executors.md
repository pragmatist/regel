---
currentMenu: action_executors
---

# Creating action executors

Actions determine what happens when a rule should be applied. Each action is executed by an action executor.

If you want to create your own actions and executors, you simply need to implement the `Pragmatist\Regel\Action\Action`
and `Pragmatist\Regel\Action\ActionExecutor` interfaces.

Let's create an action executor which turns actions into method calls on the subject.

First, we need to create our action.

```php
use Pragmatist\Regel\Action\Action;

final class SubjectMethodAction implements Action
{
    private $methodName;
    private $parameters = [];
    
    public function __construct($methodName, array $parameters = [])
    {
        $this->methodName = $methodName;
        $this->parameters = $parameters;
    }
    
    public function __invoke($subject)
    {
        call_user_func_array([$subject, $this->methodName], $this->parameters);
    }
}
```

Our class makes us specify the method to call and its parameters upon instantiation. We then use the `__invoke` method
to make our action callable when the action needs to be executed. It calls the defined method on the subject, and
passes in the provided parameters.

At this point we wouldn't have to write our own action executor, as the `CallableActionExecutor` is able to execute
callable actions. We're going to do so anyway to see how it could be done.

```php
use Pragmatist\Regel\Action\ActionExecutor;

final class SubjectMethodActionExecutor implements ActionExecutor
{
    public function execute(Action $action, $subject)
    {
        if (!$condition instanceof SubjectMethodAction) {
            throw new \LogicException('This executor only handles actions of type SubjectMethodAction');
        }
        
        $action($subject);
    }
}
```

We only define a single function, which takes the action and the subject. It calls the action, passing in the subject.

Now let's bring all of the above together and use our new subject method action.

First lets define the actual subject of the rules; a class that represents a message.

```php
final class Message
{
    private $subject;
    private $body;
    
    public function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }
    
    public function subject()
    {
        return $this->subject;
    }
    
    public function body()
    {
        return $this->body;
    }
    
    public function prefixSubject($prefix)
    {
        $this->subject = $prefix . $subject;
    }
}
```

Our message does not do a lot. It only has a subject and a body, and a single method which allows us to prefix the
subject. That's the method we would like to call when our rule matches.

Let's see how we would bring everything together.

```php
use Pragmatist\Regel\Condition\CallableCondition;
use Pragmatist\Regel\Condition\CallableConditionEvaluator;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\Rule\ActionableRule;
use Pragmatist\Regel\RuleSet\ArrayRuleSet;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

// Set up our RuleSet provider. Note that we use our custom SubjectMethodAction.
$ruleSetProvider = new InMemoryRuleSetProvider();
$ruleSetProvider->addRuleSet(
    'message-ruleset',
    new ArrayRuleSet(
        [
            new ActionableRule(
                new CallableCondition(function($subject) { return preg_match('/important/i', $subject->body); }),
                new SubjectMethodAction('prefixSubject', ['IMPORTANT: '])
            )
        ]
    )
);

// Set up the RuleEngine with our own SubjectMethodActionExecutor.
$engine = new ActionEngine(
    $ruleSetProvider,
    new CallableConditionEvaluator(),
    new SubjectMethodActionExecutor()
);

// Apply the ruleset to a subject
$message = new Message('My message', 'This message is very important and should be read.');
$engine->applyRuleSetToSubject('message-ruleset', $message);

echo $message->subject(); // Outputs "IMPORTANT: My message"
```

