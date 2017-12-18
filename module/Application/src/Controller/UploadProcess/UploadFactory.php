<?php
/**
 * Created by PhpStorm.
 * User: vitaliibezgin
 * Date: 12/18/17
 * Time: 1:23 PM
 */

namespace Application\Controller\UploadProcess;

use Application\Controller\UploadProcess\UploadManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\UploadProcess\UploadController;

class UploadFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $uploadManager = $container->get(UploadManager::class);

        return new UploadController ($entityManager,$uploadManager);
    }
}