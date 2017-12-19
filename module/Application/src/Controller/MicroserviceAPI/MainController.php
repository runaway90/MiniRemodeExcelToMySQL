<?php
namespace Controller\MicroserviceAPI;

use Zend\Mvc\Controller\AbstractRestfulController,
    Zend\View\Model\JsonModel;

class MainController extends AbstractRestfulController
{
    public function apiAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $testEntity = $em->getRepository('Test')->findAll();

        foreach ($testEntity as $entity) {
           $array[] = $entity->getJsonData();
        }

        return new JsonModel(array('response' => $array));
    }
}
