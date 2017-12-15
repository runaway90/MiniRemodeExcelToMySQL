<?php
namespace Application\Controller;

use \Application\Form\UploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Zend\Filter\File\Rename;

class UploadController extends AbstractActionController
{
    public function uploadAction()
    {
        $form = new UploadForm('upload');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                //var_dump($data);
                $formate = new FormattedController();
                $formate->rewriteMedicalDB($data["name"],$data["tmp_name"]);

                return $this->redirect()->toRoute('fileisload', ['action' => 'fileIsLoad']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

}
