<?php

namespace Application\Controller;

use Application\Entity\ListOfConcurrent;
use Application\Entity\ListOfMedicament;

class FormattedController
{

    public function rewriteMedicalDB($filePath)
    {
        var_dump($filePath);
        $objPHPExcel = \PHPExcel_IOFactory::load($filePath);
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        $countSheet = $objPHPExcel->getSheetCount();

        $array = [];
        for ($aSheet; $aSheet <= $countSheet; $aSheet++){
            $rows = $aSheet->getRowIterator();
            foreach($rows as $row){
                $cellIterator = $row->getCellIterator();
                $item = [];

                foreach($cellIterator as $cell){
                    $formcell = explode(",",$cell->getCalculatedValue());
                    array_push($item, $formcell);
                }

                array_push($array, $item);
            }
            var_dump($array);
            die();

        }

        return $array;
    }

        //$reader = new \PHPExcel_Reader_Excel2007();
        //$excel = $reader->load($filePath);
        //$worksheets = $excel->getAllSheets();

        //var_dump($worksheets);

        /**
        //'/var/www/html/ExcelToMySQL/module/Application/upload_files/'

        //add new ListOfMedicament
        $listOfMedicament = new ListOfMedicament();
        //add new ListOfConcurrent
        $listOfConcurrent = new ListOfConcurrent();

        //for all sheets as one
        foreach ($worksheets as $worksheet) {

            $title = $worksheet->getTitle();
            var_dump($title);
            $rowCount = $worksheet->getHighestRow();
            $rowIterator = $worksheet->getRowIterator();
            $rowNumber = $rowIterator->seek(1);

            $columnIterator = $worksheet->getColumnIterator();
            $columnNumber = $columnIterator->seek(A);

            $activeCell = $worksheet->getActiveCell();
            if ($title = 'list_of_medicament'){

                if($columnNumber = 'A') {
                    for ($rowNumber = 2; $rowNumber <= $rowCount; $rowNumber++)
                    {
                        $listOfMedicament->setName($activeCell);
                    }
                    $columnIterator->next();
                }

                if($columnNumber = 'B'){
                    for ($rowNumber = 2; $rowNumber <= $rowCount; $rowNumber++)
                    {
                        $listOfMedicament->setIdConcurrent($this->rebuildString($activeCell));
                    }
                }
            }else{
                //echo 'You haven`t sheets "list_of_medicament". Please change it';
            }

            if($title = 'list_of_concurrent'){

                if($columnNumber = 'A'){
                    for ($rowNumber = 2; $rowNumber <=$rowCount; $rowNumber++)
                        {
                            $listOfConcurrent->setName($activeCell);
                        }
                    $columnIterator->next();
                }

                if($columnNumber = 'B'){
                    for ($rowNumber = 2; $rowNumber <=$rowCount; $rowNumber++)
                        {
                            $listOfConcurrent->setIngrid($activeCell);
                        }
                    $columnIterator->next();
                }

                if($columnNumber = 'C'){
                    for ($rowNumber = 2; $rowNumber <=$rowCount; $rowNumber++)
                        {
                            $listOfConcurrent->setNameConcurrent($activeCell);
                        }
                }
            }else{
                //echo 'You haven`t sheets "list_of_medicament" and "list_of_concurrent". Please change it';
            }
        }*/


    /*
     * @var string $cell
     */
    public function rebuildString($cell)
    {
        $explodeCell = explode(',', $cell);

        return $explodeCell;
    }

}
