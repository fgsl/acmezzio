<?php

declare(strict_types=1);

namespace Equipment\Handler;

use Equipment\Model\Equipment;
use Equipment\Model\EquipmentTable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use stdClass;

class EquipmentHandler implements RequestHandlerInterface
{
    private EquipmentTable $dtgEquipment;

    public function __construct(EquipmentTable $dtgEquipment)
    {
        $this->dtgEquipment = $dtgEquipment;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $response = new \stdClass();
        if ($request->getMethod() == 'POST') {
            $response->operation = 'insert';
            $data = json_decode($request->getBody()->getContents(), true);
            $data = $data ?? $_POST;
            $equipment = new Equipment('');
            $equipment->exchangeArray($data);
            if ($this->dtgEquipment->save($equipment)) {
                $response->status = 'success';
                $response->code = $this->dtgEquipment->getLastCode();
            } else {
                $response->status = 'fail';
            }
        }

        if ($request->getMethod() == 'GET') {
            $response->operation = 'select';
            $id = (int)$request->getAttribute('id');
            $response = $this->dtgEquipment->find($id);
        }

        if ($request->getMethod() == 'DELETE') {
            $response->operation = 'delete';
            $id = (int) $request->getAttribute('id');
            if ($this->dtgEquipment->remove($id)){
                $response->status = 'success';
            } else {
                $response->status = 'fail';
            }
        }

        return new JsonResponse($response);
    }
}
