# Mediator

A dynamic mediator simulator

## Why

[Mediator][2] and Observer patterns are very close in features but very different
in terms of coding.

Mediator is a good pattern because in most time, it's more easy to debug
than Observer since it's easier to track method invocations.

But Mediator has a big flaw : it's a like a God object if you don't use [ISP][1] to
split its usually-big public contract. And it's a dull job to do this when you
start a project since interfaces of Colleagues are not frozen, each change
must be repeated two or three times (ripple effect). Observer does not have
this problem but it's too loosely coupled to keep strong type-hinting in method
parameters.

Since it's very difficult to refactor an Observer to a Mediator during project 
developement, this simulator acts like an Mediator but it is coded like a Observer.

## What

So, this tool helps you to simulate a Mediator in early stage of development.
Since there is absolutely no strong type-hinting, it is not suited for production.

When your Colleagues are in a more stable state, start coding a real Mediator.

## How

Each colleague must have a pointer to the mediator (I provide a trait ColleagueImpl
but since this is soft-typing, it is not mandatory). Notice that colleague
only knows Mediator, not Subscriber, it will be a problem if Colleagues can
change their subscribing.

Subscribing :

a fluent interface is provided to subscribe each colleague and which methods
can be accessed to other colleagues (to prevent name collisions and to run faster)

```
$mediator
        ->export($emit, array())
        ->export($recv, array('handleRequest'));
```

$emit has no public method for $recv but $recv has a public method for $emit

You can alias a method by providing an alias in the key :
```
$mediator
        ->export($emit, array())
        ->export($recv, array('handle' => 'handleRequest'));
```

$emit will call 'handle()' and the mediator redirects to 'handleRequest' method of $recv

There is also a method for exporting all methods from an object :
```
$mediator
        ->exportAll($emit)
        ->exportAll($recv);
```
will subscribe all non-static, non-magic, public methods from $emit and $recv :
use it with cautions.

See unit tests for futher informations.

## Note

The subscriber checks on name collisions on aliases.

When you start to code the real Mediator, don't forget to declare one or more
interfaces to follow "[Interface Segregation Principle][1]". Each colleagues must
only see a small part of the Mediator public contract. This pattern needs a lot
of abstraction.

One little warning : perhaps you think this looks like a dispatcher. That's not
true. A dispatcher will propagate an event to **all** colleagues, unlike the 
purpose of the Mediator (but it can be misused like a dispatcher)
If you need to notify one event to multiple receivers, use a dispatcher pattern. 

[1]: http://en.wikipedia.org/wiki/Interface_segregation_principle
[2]: http://en.wikipedia.org/wiki/Mediator_pattern