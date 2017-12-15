<?php

namespace Application\Controller\ListOfMedicament;

use Application\Entity\ListOfConcurrent;
use Application\Entity\ListOfMedicament;
use Doctrine\ORM\EntityManager;

class AddToDBController
{
 /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewInfoToListOfMedicament($data)
    {
        $add = new ListOfMedicament();
        $add->setIdConcurrent($data['id_concurrent']);
        $add->setName($data['name']);

        $this->entityManager->persist($add);
        $this->entityManager->flush();
    }

    public function addNewInfoToListOfConcurrent($data)
    {
        $add = new ListOfConcurrent();
        $add->setName($data['name_pre']);
        $add->setIngrid($data['ingrid']);
        $add->setNameConcurrent($data['name_concurrent']);

        $this->entityManager->persist($add);
        $this->entityManager->flush();
    }

    public function addConcurrentNameToIdByName()
    {
        $list = new ListOfConcurrent();
        $list->getListOfMedicament();

        $add = new ListOfConcurrent();
        $add->addListOfMedicament($list);

        $this->entityManager->persist($add);
        $this->entityManager->flush();
    }

}
