<?php

declare(strict_types=1);

namespace Equipment\Handler;

use AppTest\InMemoryContainer;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\TestCase;

final class EquipmentHandlerFactoryTest extends TestCase
{
    private $container;

    public function setUp(): void
    {
        parent::setUp();
        $this->container = require __DIR__ . '/../../../config/container.php';
    }

    public function testFactory(): void
    {
        $this->container->setService(RouterInterface::class, $this->createMock(RouterInterface::class));

        $factory  = new EquipmentHandlerFactory();
        $handler = $factory($this->container);

        self::assertInstanceOf(EquipmentHandler::class, $handler);
    }

}
