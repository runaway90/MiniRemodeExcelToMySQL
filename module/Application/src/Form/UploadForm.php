<?php
/**
 * Created by PhpStorm.
 * User: vitaliibezgin
 * Date: 12/11/17
 * Time: 12:52 PM
 */

namespace Application\Form;

use Zend\Form\Element\File as FileElement;
use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        // FileElement
        $file = new FileElement('excel-file');
        $file->setLabel('File excel')
             ->setAttribute('id', 'excel-file')
             ->setAttribute("enctype", "multipart/form-data");
        $this->add($file);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();
        //$this->setUseInputFilterDefaults(false);
        $fileInput = new FileInput('excel-file');
        $fileInput->setRequired(true);
        $fileInput->getFilterChain()
                  ->attachByName('FileRenameUpload',
                      array(
                          'target' => '/var/www/html/ExcelToMySQL/module/Application/upload_files',
                          'useUploadName'=>true,
                          'useUploadExtension'=>true,
                          'overwrite'=>true,
                          'randomize' => false));

        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }

}
