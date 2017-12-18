<?php

namespace Application\Controller;

use Application\Controller\ListOfMedicament\AddToDBController;
use Doctrine\ORM\EntityManager;

class FormattedController
{

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
                    $formcell = explode(",",$cell->getCalculatedValue());
                    str_replace('&reg;','',$formcell);
                    array_push($item, $formcell);
                }

                /**
                 * Doctrine entity manager.
                 * @var $entityManager EntityManager
                 */
                $addToTable = new AddToDBController($entityManager);
                $addToTable->addNewInfoToListOfMedicament($item);

            }

        $aSheet = $objPHPExcel->getSheetByName('list_of_concurrent');
        $rows = $aSheet->getRowIterator();

            foreach($rows as $row){
                $cellIterator = $row->getCellIterator();
                $item = [];

                foreach($cellIterator as $cell){
                    $formcell = explode(",",$cell->getCalculatedValue());
                    str_replace('&reg;','',$formcell);
                    array_push($item, $formcell);
                }

                /**
                 * Doctrine entity manager.
                 * @var $entityManager EntityManager
                 */
                $addToTable = new AddToDBController($entityManager);
                $addToTable->addNewInfoToListOfConcurrent($item);
            }

    }


    public function rebuildString($cell)
    {
        $decode = strtr($cell, "®", '');
        $explodeCell = explode(',', $decode);

        return $explodeCell;
    }


}
