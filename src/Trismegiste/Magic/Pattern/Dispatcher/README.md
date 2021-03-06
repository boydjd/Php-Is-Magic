# Dispatcher-like pattern

Two kinds of Dispatcher

## What

This is like a dispatcher. I can't really
say it is a dispatcher "by the book". Usually, it involves a subscribing
contract for components. For a standard and well-coded dispatcher, use the one
from Symfony, it is quite loosely-coupled and simple to use.

## Why

Here I wanted to explore Reflection and not use interfaces for dispatching, 
subscribing and components. The goal is to emulate the dispatcher pattern 
within legacy code and quickly evaluate if this pattern fits in.

## Soft-typed dispatcher

Very simple actually. All object's methods with one parameter with a 
type-hint "Event" are subscribed no matter the type of the object.

It also works if the type-hint is a subclass of Event. 

```php
$dispatcher = new SoftDispatcher();
// $someObj has a method doSomething(Event $e)
$dispatcher->addListener($someObj);
$dispatcher->dispatch('doSomething', new ConcreteEvent());
-- or --
$dispatcher->dispatchDoSomething(new ConcreteEvent());
// all objects with method doSomething(Event $e) will be called
```

Just like that.

## Strong-typed Dispatcher

This is the same as the soft-typed dispatcher except methods are limited to
one interface.

```php
$dispatcher = new StrongDispatcher('MyInterface');
// $someObj implements the method doSomething(Event $e) from MyInterface
$dispatcher->addListener($someObj);
$dispatcher->dispatch('doSomething', new ConcreteEvent());
-- or --
$dispatcher->dispatchDoSomething(new ConcreteEvent());
// all objects with method doSomething(Event $e) will be called
```

You have strong typing and be sure to launch events without chance of NPE.

## Note

When your API is frozen, you should add an interface with
the common called methods and add subscribing with a standard dispatcher.

If only one specific object need to be called each time, you don't need a dispatcher
but a Mediator. 

There is no error or exception if an event is not caught by any component.

Despite the soft-typing, these emulators are quite safe due to multiple validators.

Have fun.
