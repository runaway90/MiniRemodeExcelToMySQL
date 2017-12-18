<?php
namespace Application\Controller\UploadProcess;

use \Application\Form\UploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class UploadController extends AbstractActionController
{
    /**
     * @var $entityManager EntityManager
     */
    private $entityManager;

    /**
     * @var $uploadManager UploadManager
     */
    private $uploadManager;

    public function __construct($entityManager, $uploadManager)
    {
        $this->entityManager = $entityManager;
        $this->uploadManager = $uploadManager;
    }

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

                $root = $data['excel-file']["tmp_name"];
                $aploadManager = new UploadManager($this->entityManager);
                $aploadManager->rewriteMedicalDB($root);
                return $this->redirect()->toRoute('upload', ['action' => 'isload']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function isloadAction()
    {
        return new ViewModel();
    }

}
