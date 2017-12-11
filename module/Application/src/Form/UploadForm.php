<?php
/**
 * Created by PhpStorm.
 * User: vitaliibezgin
 * Date: 12/11/17
 * Time: 12:52 PM
 */

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('File excel')
             ->setAttribute('id', 'image-file');
        $this->add($file);
    }

}
