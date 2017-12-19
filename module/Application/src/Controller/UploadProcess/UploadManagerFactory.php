<?php

namespace Application\Controller\UploadProcess;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\UploadProcess\UploadManager;

class UploadManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                    $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new UploadManager($entityManager);
    }

}
