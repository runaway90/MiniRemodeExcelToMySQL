<?php

namespace Application\Controller\UploadProcess;

use Application\Entity\ListOfConcurrent;
use Application\Entity\ListOfMedicament;
use Doctrine\ORM\EntityManager;

class UploadManager
{
     /**
     * @var $entityManager EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function rewriteMedicalDB($filePath)
    {
        var_dump($filePath);
        $objPHPExcel = \PHPExcel_IOFactory::load($filePath);

        $aSheet = $objPHPExcel->getSheetByName('list_of_medicament');
        $rows = $aSheet->getRowIterator();

        foreach($rows as $row){
            $cellIterator = $row->getCellIterator();
            $medicament = [];

            foreach($cellIterator as $cell){
                $withoutsymbols =  strtr($cell->getCalculatedValue(),"®",'');
                $formcell = explode(",",$withoutsymbols);
                array_push($medicament, $formcell);
            }
            //var_dump($medicament);
            $listMedicament = new ListOfMedicament();
            $listMedicament->setName($medicament[0]);
            $listMedicament->setIdConcurrent($medicament[1]);

            //$this->entityManager->persist($listMedicament);
            //$this->entityManager->flush();

        }
            //var_dump($item);
            //die();

        $aSheet = $objPHPExcel->getSheetByName('list_of_concurrent');
        $rows = $aSheet->getRowIterator();

        foreach($rows as $row){
            $cellIterator = $row->getCellIterator();
            $concurrent = [];

            foreach($cellIterator as $cell){
                $withoutsymbols =  strtr($cell->getCalculatedValue(),"®",'');
                $formcell = explode(",",$withoutsymbols);
                array_push($concurrent, $formcell);
            }

            var_dump($concurrent);
            $listConcurrent = new ListOfConcurrent();
            $listConcurrent->getName($concurrent[0]);
            $listConcurrent->getIngrid($concurrent[1]);
            $listConcurrent->getNameConcurrent($concurrent[2]);

            $this->entityManager->persist($listConcurrent);
            $this->entityManager->flush();

        }

    }

    public function rebuildString($cell)
    {
        $decode = strtr($cell, "®", '');
        $explodeCell = explode(',', $decode);

        return $explodeCell;
    }
}