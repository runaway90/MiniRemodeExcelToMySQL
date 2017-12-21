<?php

namespace Notification\Controller;

use Doctrine\ORM\EntityManager;
use Notification\Model\Notification;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class NotificationController extends AbstractRestfulController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get($id): JsonModel
    {
        $notification = $this->entityManager->getRepository(Notification::class)->findOneById($id);

        $data = [
            'id' => $notification->getId(),
            'title' => $notification->getType()->getTitle(),
            'url' => $notification->getUrl(),
            'description' => $notification->getDescription(),
            'read' => $notification->getRead(),
            'date_created' => $notification->getCreationDate()->format('Y-m-d H:i:s')
        ];

        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getList(): JsonModel
    {
        $data = [];
        $notifications = $this->entityManager->getRepository(Notification::class)->findAll();

        /**
         * @var Notification $notification
         */
        foreach($notifications as $notification) {
            $data[] = [
                'id' => $notification->getId(),
                'title' => $notification->getType()->getTitle(),
                'url' => $notification->getUrl(),
                'description' => $notification->getDescription(),
                'read' => $notification->getRead(),
                'date_created' => $notification->getCreationDate()->format('Y-m-d H:i:s')
            ];
        }

        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getListForUserAction(): JsonModel
    {
        $id = $this->params()->fromRoute('id');
        $notifications = $this->entityManager->getRepository(Notification::class)->findByUser($id);
        $data = [];

        /**
         * @var Notification $notification
         */
        foreach($notifications as $notification) {
            $data[] = [
                'id' => $notification->getId(),
                'title' => $notification->getType()->getTitle(),
                'url' => $notification->getUrl(),
                'description' => $notification->getDescription(),
                'read' => $notification->getRead(),
                'date_created' => $notification->getCreationDate()->format('Y-m-d H:i:s')
            ];
        }
        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function create($data): JsonModel
    {
        parent::update($data);
    }

    public function update($id, $data): JsonModel
    {
        /**
         * @var Notification $notification
         */
        $notification = $this->entityManager->getRepository(Notification::class)->findOneById($id);

        !isset($data['read']) ?: $notification->setRead($data['read']);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        $data = [
            'id' => $notification->getId(),
            'title' => $notification->getType()->getTitle(),
            'url' => $notification->getUrl(),
            'description' => $notification->getDescription(),
            'read' => $notification->getRead(),
            'date_created' => $notification->getCreationDate()->format('Y-m-d H:i:s')
        ];

        return new JsonModel([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function delete($id): JsonModel
    {
        parent::delete($id);
    }
}