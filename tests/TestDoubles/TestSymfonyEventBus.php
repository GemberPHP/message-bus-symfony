<?php

declare(strict_types=1);

namespace Gember\MessageBusSymfony\Test\TestDoubles;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Exception;

final class TestSymfonyEventBus implements MessageBusInterface
{
    public bool $isCalled;

    public function dispatch(object $message, array $stamps = []): Envelope
    {
        $this->isCalled = true;

        if ($message instanceof TestEventThrowingException) {
            throw new class extends Exception implements ExceptionInterface {};
        }

        return new Envelope($message);
    }
}
