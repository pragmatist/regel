---
currentMenu: what_is_regel
---

# What is Regel

Regel is a simple, extensible, business rule engine. Its primary goal is to provide you with the basic interfaces and
classes needed to construct your own rule engine specific to your needs.

## What is a business rule engine

In a software application, business rules can change more frequently than other parts of your application code. A
business rule engine executes business rules which have been separated from your application code. This separation
can allow business users to modify the rules without the intervention of a software developer.

## Rules, actions, conditions and subjects

A rule represents a business rule. A business rule always consists of a condition, and an action. If the condition
evaluates to true, the rule's action is executed.

Subjects provide the context of a rule's condition and action, and can influence the outcome of the rule.

Take the following sentence:

> When an incoming message's body contains the word "important", forward the message to Bob.

In the above sentence, the incoming message is the subject. Whether the body contains the word "important" is the rule
condition, while forwarding it to Bob is the action.
