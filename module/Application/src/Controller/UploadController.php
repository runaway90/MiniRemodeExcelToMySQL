<?php
namespace Application\Controller;

use \Application\Form\UploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
                $dir = 'var/www/html/BudgetControl/module/Application/upload_files/';
                //Zend_Loader::loadFile($data, $dir, $once=false);

                return $this->redirect()->toRoute('upload', ['action' => 'file_is_load']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

}
