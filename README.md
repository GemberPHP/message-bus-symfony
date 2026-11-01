# 🫚 Gember Message Bus: Symfony Messenger
[![Build Status](https://github.com/GemberPHP/message-bus-symfony/actions/workflows/test.yaml/badge.svg?branch=main)](https://github.com/GemberPHP/message-bus-symfony/actions/workflows/test.yaml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3-8892BF.svg?style=flat)](http://www.php.net)

[Gember Event Sourcing](https://github.com/GemberPHP/event-sourcing) Message Bus adapter based on [symfony/messenger](https://github.com/symfony/messenger).

> All external dependencies in Gember Event Sourcing are organized into separate packages,
> making it easy to swap out a vendor adapter for another.

## Installation
Install with Composer:
```bash
composer require gember/message-bus-symfony
```

## Configuration
Bind `SymfonyEventBus` to the `EventBus` interface and `SymfonyCommandBus` to the `CommandBus` interface in your service definitions.

### Examples

#### Vanilla PHP
```php
use Gember\MessageBusSymfony\SymfonyCommandBus;
use Gember\MessageBusSymfony\SymfonyEventBus;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

$eventBus = new SymfonyEventBus(
    new MessageBus([ // An event bus configuration of your choice
        new HandleMessageMiddleware(new HandlersLocator([
            SomeEvent::class => [new SomeEventSubscriber()], // callables
            // ...
        ]), allowNoHandlers: true), // events without handlers are normal
    ]),
);

$commandBus = new SymfonyCommandBus(
    new MessageBus([ // A command bus configuration of your choice
        new HandleMessageMiddleware(new HandlersLocator([
            SomeCommand::class => [new SomeCommandHandler()],
            // ...
        ])),
    ]),
);
```

#### Symfony
It is recommended to use the [Symfony bundle](https://github.com/GemberPHP/event-sourcing-symfony-bundle) to configure Gember Event Sourcing.
With this bundle, the adapters are automatically set as the default for the event bus and command bus.

If you're not using the bundle, you can bind them directly to the `EventBus` and `CommandBus` interfaces.

```yaml
Gember\DependencyContracts\Util\Messaging\MessageBus\EventBus:
  class: Gember\MessageBusSymfony\SymfonyEventBus
  arguments:
    - '@event.bus' # or any other defined Symfony event bus

Gember\DependencyContracts\Util\Messaging\MessageBus\CommandBus:
  class: Gember\MessageBusSymfony\SymfonyCommandBus
  arguments:
    - '@command.bus' # or any other defined Symfony command bus
```
