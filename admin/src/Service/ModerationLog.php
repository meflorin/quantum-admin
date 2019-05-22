<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Moderation;
use App\Entity\User;

class ModerationLog
{

    const GENERAL_DEFAULT_ACTION = 'GENERAL DEFAULT ACTION';
    const UPDATE_PROFILE_NAME = 'UPDATE PROFILE NAME';
    const UPDATE_BANNED_REASON = 'UPDATE BANNED REASON';

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $userId
     * @param string $action
     * @param string $actionBy
     * @return bool
     */
    public function logModeration($userId, $action = self::GENERAL_DEFAULT_ACTION, $actionBy = 'admin')
    {

        $userRepository = $this->em->getRepository(User::class);
        $usr = $userRepository->find($userId);

        $newModeration = new Moderation();

        $newModeration->setUser($usr);
        $newModeration->setAction($action);
        $newModeration->setCreatedAt(new \DateTime());
        $newModeration->setActionBy($actionBy);

        $this->em->persist($newModeration);
        $this->em->flush();

        return true;
    }
}
