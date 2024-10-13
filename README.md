# 🫚 Gember Message Bus: Symfony Messenger
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3-8892BF.svg?style=flat)](http://www.php.net)

[Gember Event Sourcing](https://github.com/GemberPHP/event-sourcing) Message Bus adapter based on [symfony/messenger](https://github.com/symfony/messenger).

> All external dependencies in Gember Event Sourcing are organized into separate packages,
> making it easy to swap out a vendor adapter for another.

## Installation
Install with Composer:
```bash
composer gember/message-bus-symfony
```

## Configuration
Bind this adapter to the `EventBus` interface in your service definitions.

### Examples

#### Vanilla PHP
```php
use Gember\MessageBusSymfony\SymfonyEventBus;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

$finder = new SymfonyEventBus(
    new MessageBus([ // An EventBus configuration of your choice
        new HandleMessageMiddleware(new HandlersLocator([
            SomeEvent::class => [SomeEventSubscriber::class],
            // ...
        ])),     
    ]), 
);
```

#### Symfony
It is recommended to use the [Symfony bundle](https://github.com/GemberPHP/event-sourcing-symfony-bundle) to configure Gember Event Sourcing.
With this bundle, the adapter is automatically set as the default for Event Bus.

If you're not using the bundle, you can bind it directly to the `EventBus` interface.

```yaml
Gember\EventSourcing\Util\Messaging\MessageBus\EventBus:
  class: Gember\MessageBusSymfony\SymfonyEventBus
  arguments:
    - '@event.bus' # or any other defined Symfony event bus
```
