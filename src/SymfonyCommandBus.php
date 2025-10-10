<?php

declare(strict_types=1);

namespace Gember\MessageBusSymfony;

use Gember\DependencyContracts\Util\Messaging\MessageBus\CommandBus;
use Gember\DependencyContracts\Util\Messaging\MessageBus\HandlingMessageFailedException;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Override;

final readonly class SymfonyCommandBus implements CommandBus
{
    public function __construct(
        private MessageBusInterface $commandBus,
    ) {}

    #[Override]
    public function handle(object $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (ExceptionInterface $exception) {
            throw HandlingMessageFailedException::withException($exception);
        }
    }
}
