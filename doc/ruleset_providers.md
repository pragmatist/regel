---
currentMenu: ruleset_providers
---

# Rule set providers

Before rules can be applied to subjects, they need to be retrieved from somewhere. Rule set providers take care of that.
They provide rule sets to the rule engine.

Regel ships with the `InMemoryRuleSetProvider` which allows you to simply inject the rule sets into it, but usually you
would want some persistence layer instead.

If you want to create your own rule set provider, you simply need to implement the
`Pragmatist\Regel\RuleSetProvider\RuleSetProvider` interface and inject your class into the engine.

Let's create a rule set provider that stores and retrieves rule sets from files.

```php
use League\Flysystem\Filesystem;
use Pragmatist\Regel\RuleSetProvider\RuleSetProvider;

final class FilesystemRuleSetProvider implements RuleSetProvider
{
    private $filesystem;
    
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    
    public function addRuleSet($identifier, RuleSet $ruleSet)
    {
        $this->filesystem->write(
            $identifier,
            serialize($ruleSet)
        );
    }

    public function getRuleSetIdentifiedBy($identifier)
    {
        if ($this->filesystem->has($identifier)) {
            return unserialize($this->filesystem->read($identifier));
        }

        throw new \InvalidArgumentException('No rule set with that identifier is available.');
    }
}
```

You can now use the class as follows.

```php
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Condition\CallableConditionEvaluator;
use Pragmatist\Regel\Engine\ActionEngine;

$ruleSetProvider = new FilesystemRuleSetProvider(
    new Filesystem(new Adapter(__DIR__.'/path/to/root'))
);
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

$engine = new ActionEngine(
    $ruleSetProvider,
    new CallableConditionEvaluator(),
    new CallableActionExecutor()
);
```
