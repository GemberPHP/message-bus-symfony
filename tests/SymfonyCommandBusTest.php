<?php

declare(strict_types=1);

namespace Gember\MessageBusSymfony\Test;

use Gember\DependencyContracts\Util\Messaging\MessageBus\HandlingMessageFailedException;
use Gember\MessageBusSymfony\SymfonyCommandBus;
use Gember\MessageBusSymfony\Test\TestDoubles\TestCommand;
use Gember\MessageBusSymfony\Test\TestDoubles\TestCommandThrowingException;
use Gember\MessageBusSymfony\Test\TestDoubles\TestSymfonyCommandBus;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class SymfonyCommandBusTest extends TestCase
{
    private SymfonyCommandBus $commandBus;
    private TestSymfonyCommandBus $symfonyCommandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = new SymfonyCommandBus(
            $this->symfonyCommandBus = new TestSymfonyCommandBus(),
        );
    }

    #[Test]
    public function itShouldHandleCommand(): void
    {
        $this->commandBus->handle(new TestCommand());

        self::assertTrue($this->symfonyCommandBus->isCalled);
    }

    #[Test]
    public function itShouldThrowExceptionWhenHandlingCommandFailed(): void
    {
        self::expectException(HandlingMessageFailedException::class);

        $this->commandBus->handle(new TestCommandThrowingException());
    }
}
