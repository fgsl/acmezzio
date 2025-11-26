<?php

declare(strict_types=1);

namespace Equipment\Handler;

use Equipment\Model\EquipmentTable;
use Laminas\Db\TableGateway\TableGateway;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class EquipmentHandlerFactory
{
    public function __invoke(ContainerInterface $container) : EquipmentHandler
    {
        $adapter = $container->get('DbAdapter');
        $tableGateway = new TableGateway('equipment',$adapter);
        $equipmentTable = new EquipmentTable($tableGateway);
        return new EquipmentHandler($equipmentTable);
    }
}
