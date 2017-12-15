<?php

namespace Application\Controller;

use Application\Entity\ListOfConcurrent;
use Application\Entity\ListOfMedicament;

class FormattedController
{

    public function rewriteMedicalDB($fileName, $filePath)
    {
        //$objPHPExcel = new \PHPExcel();

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel=$objReader->load($filePath.'/'.$fileName);
        $worksheets = $objPHPExcel->getAllSheets();
        //'/var/www/html/ExcelToMySQL/module/Application/upload_files/'
        //add new ListOfMedicament
        $listOfMedicament = new ListOfMedicament();
        //add new ListOfConcurrent
        $listOfConcurrent = new ListOfConcurrent();

        //for all sheets as one
        foreach ($worksheets as $worksheet) {

            $title = $worksheet->getTitle();

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
        }
    }

    /*
     * @var string $cell
     */
    public function rebuildString($cell)
    {
        $explodeCell = explode(',', $cell);

        return $explodeCell;
    }

}
