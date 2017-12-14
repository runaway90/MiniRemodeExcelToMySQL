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
use Zend\InputFilter\InputFilter;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        //$this->addInputFilter();

    }

    public function addElements()
    {
        // FileElement
        $file = new FileElement('excel-file');
        $file->setLabel('File excel')
             ->setAttribute('id', 'excel-file');
        $this->add($file);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();

        // File Input
        $fileInput = new FileInput('excel-file');
        $fileInput->setRequired(true);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => './upload_files/.xls',
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }

}
