<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use App\Service\ModerationLog;

use App\Entity\Banned;

class BannedController extends BaseAdminController
{
    private $moderationLogService;

    public function __construct(ModerationLog $modLog)
    {
        $this->moderationLogService = $modLog;
    }

    public function updateBannedEntity($entity)
    {
        $id = $this->request->query->get('id');

        $conn = $this->em->getConnection();
        $sql = "SELECT reason, user_id FROM banned WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $banned = $stmt->fetchAll();

        if (count($banned) > 0) {

            if ($entity->getReason() != $banned[0]['reason']) {
                $this->moderationLogService->logModeration($banned[0]['user_id'], $this->moderationLogService::UPDATE_BANNED_REASON);
            }
        }

        parent::updateEntity($entity);
    }
}