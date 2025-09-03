<?php

declare(strict_types=1);

namespace Gember\MessageBusSymfony;

use Gember\DependencyContracts\Util\Messaging\MessageBus\EventBus;
use Gember\DependencyContracts\Util\Messaging\MessageBus\HandlingMessageFailedException;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Override;

final readonly class SymfonyEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $eventBus,
    ) {}

    #[Override]
    public function handle(object $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (ExceptionInterface $exception) {
            throw HandlingMessageFailedException::withException($exception);
        }
    }
}
