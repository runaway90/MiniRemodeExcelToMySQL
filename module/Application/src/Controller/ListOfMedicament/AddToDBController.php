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
        $add->setIdConcurrent($data[1]);
        $add->setName($data[0]);

        $this->entityManager->persist($add);
        $this->entityManager->flush();
    }

    public function addNewInfoToListOfConcurrent($data)
    {
        $add = new ListOfConcurrent();
        $add->setName($data[0]);
        $add->setIngrid($data[1]);
        $add->setNameConcurrent($data[2]);

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
