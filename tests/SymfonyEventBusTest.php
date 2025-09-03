<?php

declare(strict_types=1);

namespace Gember\MessageBusSymfony\Test;

use Gember\DependencyContracts\Util\Messaging\MessageBus\HandlingMessageFailedException;
use Gember\MessageBusSymfony\SymfonyEventBus;
use Gember\MessageBusSymfony\Test\TestDoubles\TestEvent;
use Gember\MessageBusSymfony\Test\TestDoubles\TestEventThrowingException;
use Gember\MessageBusSymfony\Test\TestDoubles\TestSymfonyEventBus;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class SymfonyEventBusTest extends TestCase
{
    private SymfonyEventBus $eventBus;
    private TestSymfonyEventBus $symfonyEventBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventBus = new SymfonyEventBus(
            $this->symfonyEventBus = new TestSymfonyEventBus(),
        );
    }

    #[Test]
    public function itShouldHandleEvent(): void
    {
        $this->eventBus->handle(new TestEvent());

        self::assertTrue($this->symfonyEventBus->isCalled);
    }

    #[Test]
    public function itShouldThrowExceptionWhenHandlingEventFailed(): void
    {
        self::expectException(HandlingMessageFailedException::class);

        $this->eventBus->handle(new TestEventThrowingException());
    }
}
