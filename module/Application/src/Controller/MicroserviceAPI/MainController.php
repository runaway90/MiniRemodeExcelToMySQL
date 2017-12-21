<?php
namespace Controller\MicroserviceAPI;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class MainController extends AbstractRestfulController
{
    /**
     * @var $entityManager EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get($name)
    {
        $model = $this->entityManager->getRepository(MainController::class)->findOneById($name);
        /**
         * @var ModelAPI $model
         */
        $data = [
            'ingrid' => $model->getIngrid(),
            'name' => $model->getName(),
            'id_concurrent' => $model->getIdConcurrent(),
            'name_concurrent' => $model->getNameConcurrent(),
        ];

        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * @var JsonModel $data
     */
    public function create($data)
    {
        parent::update($data);
    }

    public function update($name, $data)
    {
        /**
         * @var ModelAPI $model
         */
        $model = $this->entityManager->getRepository(ModelAPI::class)->findOneById($name);

        !isset($data['name']) ?: $model->setName($data['name']);

        $this->entityManager->persist($model);
        $this->entityManager->flush();

        $data = [
            'ingrid' => $model->getIngrid(),
            'name' => $model->getName(),
            'id_concurrent' => $model->getIdConcurrent(),
            'name_concurrent' => $model->getNameConcurrent(),
        ];

        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * @var JsonModel $data
     */
    public function delete($data)
    {
        parent::delete($data);
    }

    public function apiTestAction()
    {
        /**
         * @var $entityManager EntityManager
        */
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $testEntity = $entityManager->getRepository(ModelAPI::class)->findAll();

        foreach ($testEntity as $entity) {
           $array[] = $entity->getJsonData();
        }

        return new JsonModel(array('response' => $array));
    }
}
