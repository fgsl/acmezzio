<?php

declare(strict_types=1);

namespace Equipment\ModelTest;

use Equipment\Model\Equipment;
use Equipment\Model\EquipmentTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DatabaseTest extends TestCase
{
    private ContainerInterface $container;

    public function setUp(): void
    {
        $config = require realpath(__DIR__ . '/../../../config') . '/config.php';

        $dependencies                       = $config['dependencies'];
        $dependencies['services']['config'] = $config;

        $this->container = new ServiceManager($dependencies);
    }

    public function testInsertAndDelete()
    {
        $adapter = $this->container->get('DbAdapter');
        $tableGateway = new TableGateway('equipment',$adapter);
        $equipmentTable = new EquipmentTable($tableGateway);
        $equipment = new Equipment('refrigerator');
        $this->assertEquals(1,$equipmentTable->save($equipment));
        $equipment = $equipmentTable->findByName('refrigerator');
        $this->assertEquals(1,$equipmentTable->remove($equipment->code));
    }
}