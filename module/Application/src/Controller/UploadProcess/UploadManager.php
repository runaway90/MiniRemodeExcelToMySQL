<?php

namespace Application\Controller\UploadProcess;

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
            $item = [];

            foreach($cellIterator as $cell){
                $withoutsymbols =  strtr($cell->getCalculatedValue(),"®",'');
                $formcell = explode(",",$withoutsymbols);
                array_push($item, $formcell);
            }
            //var_dump($item);
            //die;
            $list = new ListOfMedicament();
            $list->setName($item[0]);
            $list->setIdConcurrent($item[1]);

            var_dump($this->entityManager);
            $this->entityManager->persist($list);
            $this->entityManager->flush();
            die();

        }}
/**
        $aSheet = $objPHPExcel->getSheetByName('list_of_concurrent');
        $rows = $aSheet->getRowIterator();

        foreach($rows as $row){
            $cellIterator = $row->getCellIterator();
            $item = [];

            foreach($cellIterator as $cell){
                $withoutsymbols =  strtr($cell->getCalculatedValue(),"®",'');
                $formcell = explode(",",$withoutsymbols);
                array_push($item, $formcell);
            }
*/
            /**
             * Doctrine entity manager.
             * @var $entityManager EntityManager

            $addToTable = new AddToDBController($entityManager);
            $addToTable->addNewInfoToListOfConcurrent($item);
        }

    }*/


    public function rebuildString($cell)
    {
        $decode = strtr($cell, "®", '');
        $explodeCell = explode(',', $decode);

        return $explodeCell;
    }
}