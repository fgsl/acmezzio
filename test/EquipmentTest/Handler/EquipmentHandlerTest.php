<?php

declare(strict_types=1);

namespace EquipmentTest\Handler;

use Equipment\Handler\EquipmentHandler;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

final class EquipmentHandlerTest extends TestCase
{
    private $container;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->container = require __DIR__ . '/../../../config/container.php';
    }

    public function testPostAndDelete(): void
    {
        $handler = $this->container->get(EquipmentHandler::class);

        $json = json_encode([
            'name' => 'Roadrunner catcher'
        ]);

        $body = new Stream('php://memory', 'wb+');
        $body->write($json);
        $body->rewind();

        $request = (new ServerRequest())
            ->withMethod('POST')
            ->withUri(new Uri('http://localhost:8000/equipment'))
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);

        $response = $handler->handle($request);
        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(property_exists($json, 'status') && $json->status == 'success');
            self::assertTrue(property_exists($json, 'operation') && $json->operation == 'insert');
        
        $code = $json->code;

        $request = (new ServerRequest())
            ->withMethod('GET')
            ->withUri(new Uri('http://localhost:8000/equipment'))
            ->withHeader('Content-Type', 'application/json')
            ->withAttribute('id',$code);

        $response = $handler->handle($request);
        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(property_exists($json, 'name') && 'Roadrunner catcher' == $json->name);

        $request = (new ServerRequest())
            ->withMethod('DELETE')
            ->withUri(new Uri('http://localhost:8000/equipment'))
            ->withHeader('Content-Type', 'application/json')
            ->withAttribute('id',$code);

        $response = $handler->handle($request);
        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(property_exists($json, 'status') && $json->status == 'success');
        self::assertTrue(property_exists($json, 'operation') && $json->operation == 'delete');
    }
}
