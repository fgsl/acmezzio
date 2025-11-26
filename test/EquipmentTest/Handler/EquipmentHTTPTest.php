<?php

declare(strict_types=1);

namespace EquipmentTest\Handler;

use Equipment\Handler\EquipmentHandler;
use Fgsl\Rest\Rest;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

final class EquipmentHTTPTest extends TestCase
{
    public function testPostAndDelete(): void
    {
        $data = [
            'code' => 0,
            'name' => 'Bird seed'
        ];
        
        $url = 'http://localhost:8000/equipment';

        $rest = new Rest();

        $headers = [];
        $response = $rest->doPost($data,$headers,$url,200,false);

        $json = json_decode($response, null, 512, JSON_THROW_ON_ERROR);

        self::assertTrue(property_exists($json, 'status') && $json->status == 'success');
        self::assertTrue(property_exists($json, 'operation') && $json->operation == 'insert');
        
        $code = $json->code;

        $response = $rest->doGet($headers,$url . "/$code",200,[]);

        $json = json_decode($response, null, 512, JSON_THROW_ON_ERROR);
        
        self::assertTrue(property_exists($json, 'name') && 'Bird seed' == $json->name);

        $response = $rest->doDelete($headers,$url . "/$code",200,[]);

        $json = json_decode($response, null, 512, JSON_THROW_ON_ERROR);

        self::assertTrue(property_exists($json, 'status') && $json->status == 'success');
        self::assertTrue(property_exists($json, 'operation') && $json->operation == 'delete');
    }
}
