<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FileIsLoadController extends AbstractActionController
{
    public function fileIsLoadAction(){


        echo 'Loaded';

        return new ViewModel();

    }
}