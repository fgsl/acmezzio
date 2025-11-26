<?php
namespace Equipment\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;

class EquipmentTable
{
    private TableGatewayInterface $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save(Equipment $equipment): int
    {
        $set = $equipment->toArray();
        if (empty($equipment->code)){
            unset($set['code']);
            return $this->tableGateway->insert($set);
        }
        return $this->tableGateway->update($set,['code' => $set['code']]);
    }

    public function getLastCode(): int
    {
        return $this->tableGateway->getLastInsertValue();
    }

    public function find(int $code): object
    {
        $resultSet = $this->tableGateway->select(['code' => $code]);
        return $resultSet->current();
    }

    public function findByName(string $name): object
    {
        $resultSet = $this->tableGateway->select(['name' => $name]);
        return $resultSet->current();
    }

    public function remove(int $code): int
    {
        return $this->tableGateway->delete(['code' => $code]);
    }
}