<?php
namespace Application\Controller\ListOfMedicament;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AddToDBFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                    $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new AddToDBController($entityManager);
    }

}
