<?php
/**
 * Created by PhpStorm.
 * User: vitaliibezgin
 * Date: 12/13/17
 * Time: 9:12 AM
 */

namespace Application\Controller;

use Application\Entity\ListOfMedicament;
use \Zend\Db\Adapter\Driver\Pdo\Connection as ConnectionPDO;
use Doctrine\ORM\EntityManager;

class FormattedController
{

    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function formattedData()
    {
    /** @var $em \Doctrine\ORM\EntityManager */
    $platform = $em->getConnection()->getDatabasePlatform();

        $listOfMedicament = new ListOfMedicament();
        $listOfMedicament->getId();

        try {
        } catch (PDOException $e) {
            ('Connecting to DataBase have exception: ' . $e->getMessage());
        }
    }


    public function rewriteDB($file, $columnsLine = 0)
    {
        $fileExcel = \PHPExcel_IOFactory::load($file);
        $listOfMedicament = new ListOfMedicament();

        foreach ($fileExcel->getWorksheetIterator() as $worksheet) {
            $rowName = "A";
            $rowCount = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestRow());
            //$rowIterator=$worksheet->getRowIterator()->seek();
            for ($row = 0; $row < $rowCount; $row++) {
                $listOfMedicament->setName($worksheet->getCell('.$rowName.'));
            }

            $columnName = substr($rowName, 0, -1);
            //$columnNameForDB = str_replace(",", " .........", $columnName);
            //$columnNameForDB = explode(",", $columnName);
        }

        //$connection->prepare("CREATE TABLE " . $tableName . " (" . $columnNameForDB . " NOT NULL)");
        // Количество строк на листе Excel
        $rowsCount = $worksheet->getHighestRow();

        // Перебираем строки листа Excel
        for ($row = $columnsLine + 1; $row <= $rowsCount; $row++) {
            // Строка со значениями всех столбцов в строке листа Excel
            $valueData = "";

            // Перебираем столбцы листа Excel
            for ($column = 0; $column < $rowCount; $column++) {
                // Строка со значением объединенных ячеек листа Excel
                $merged_value = "";
                // Ячейка листа Excel
                $cell = $worksheet->getCellByColumnAndRow($column, $row);

                // Перебираем массив объединенных ячеек листа Excel
                foreach ($worksheet->getMergeCells() as $mergedCells) {
                    // Если текущая ячейка - объединенная,
                    if ($cell->isInRange($mergedCells)) {
                        // то вычисляем значение первой объединенной ячейки, и используем её в качестве значения
                        // текущей ячейки
                        $merged_value = $worksheet->getCell(explode(":", $mergedCells)[0])->getCalculatedValue();
                        break;
                    }
                }

                // Проверяем, что ячейка не объединенная: если нет, то берем ее значение, иначе значение первой
                // объединенной ячейки
                $valueData .= "'" . (strlen($merged_value) == 0 ? $cell->getCalculatedValue() : $merged_value) . "',";
            }

            // Обрезаем строку, убирая запятую в конце
            $valueData = substr($valueData, 0, -1);

            // Добавляем строку в таблицу MySQL
            //$connection->execute("INSERT INTO " . $tableName . " (" . $columnName . ") VALUES (" . $valueData . ")");

        }
        // Соединение с базой MySQL
        //$connection = new mysqli("localhost", "user", "pass", "base");
        // Выбираем кодировку UTF-8
        //$connection->set_charset("utf8");

        // Загружаем файл Excel
        //$PHPExcel_file = PHPExcel_IOFactory::load("./file.xlsx");

        // Преобразуем первый лист Excel в таблицу MySQL
        //$fileExcel->setActiveSheetIndex(0);
        //echo formattedData($fileExcel->getActiveSheet(), $connection, "", 1) ? "OK\n" : "FAIL\n";

        // Перебираем все листы Excel и преобразуем в таблицу MySQL
        //foreach ($fileExcel->getWorksheetIterator() as $index => $worksheet) {
        //    echo formattedData($worksheet, $connection, "" . ($index != 0 ? $index : ""), 1) ? "OK\n" : "FAIL\n";
        //}

/**
    public function connectWithDB($tableName)
    {
        $dataBase = new Mysqli\Mysqli(array(
        'host'     => '127.0.0.1',
        'database' => $tableName,
        'username' => 'root',
        'password' => 'root'));


    }
        $DB_host = "";
        $DB_user = "";
        $DB_pass = "";

         try
         {
             $db_con = new \PDO("mysql:host={$DB_host};dbname={$this->tableName}",$DB_user,$DB_pass);
             $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }
         catch(\PDOException $e)
         {
             echo "ERROR : ".$e->getMessage();
         }
    }
**/
    }
}
