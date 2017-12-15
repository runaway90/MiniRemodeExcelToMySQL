<?php
namespace Application\Controller;

use \Application\Form\UploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element\File;

class UploadController extends AbstractActionController
{
    public function uploadAction()
    {
        /**
         * $target_dir = "uploads/";
         * $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
         * move_uploaded_file($_FILES["name"], $target_file);
         * var_dump($_FILES);*/


        $form = new UploadForm('upload');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );


            var_dump($post);
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();

                var_dump($data);
                $formate = new FormattedController();
                $formate->rewriteMedicalDB($data["tmp_name"]);

                return $this->redirect()->toRoute('fileisload', ['action' => 'fileIsLoad']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);

    }
}
