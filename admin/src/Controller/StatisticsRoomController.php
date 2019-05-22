<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

use App\Entity\Room;
use App\Entity\RoomUser;

class StatisticsRoomController extends AdminController
{
    const GENERAL_ROOM_ID = 1;

    public function listAction()
    {
        return $this->render('easy_admin/RoomStatistics/list.html.twig', array());
    }

    public function showAction()
    {

        $totalRooms = 0;
        $publicRoomsPercent = 0;
        $privateRoomsPercent = 0;
        $privateRoomsDiscoverablePercent = 0;
        $privateRoomsUndiscoverablePercent = 0;
        $publicRooms = 0;
        $privateRooms = 0;
        $privateRoomsUndiscoverable = 0;
        $privateRoomsDiscoverable = 0;


        $publicRooms = $this->getRoomsInfo();
        $privateRooms = $this->getRoomsInfo(2, true);
        $privateRoomsUndiscoverable = $this->getRoomsInfo(2, true, false);
        $privateRoomsDiscoverable = $this->getRoomsInfo(2, true, true);

        $totalRooms = $publicRooms['nbRooms'] + $privateRoomsUndiscoverable['nbRooms'] + $privateRoomsDiscoverable['nbRooms'];
        $totalPrivateRooms = $privateRoomsUndiscoverable['nbRooms'] + $privateRoomsDiscoverable['nbRooms'];

        if ($totalRooms > 0) {
            $publicRoomsPercent = number_format($publicRooms['nbRooms'] * 100 / $totalRooms, 2, '.', '');
            $privateRoomsPercent = number_format($totalPrivateRooms * 100 / $totalRooms, 2, '.', '');
        }

        if ($totalPrivateRooms > 0) {
            $privateRoomsDiscoverablePercent = number_format($privateRoomsDiscoverable['nbRooms'] * 100 / $totalPrivateRooms, 2, '.', '');
            $privateRoomsUndiscoverablePercent = number_format($privateRoomsUndiscoverable['nbRooms'] * 100 / $totalPrivateRooms, 2, '.', '');
        }

        return $this->render('easy_admin/RoomStatistics/rooms.html.twig',
            array(
                'publicRooms' => $publicRooms,
                'privateRooms' => $privateRooms,
                'privateRoomsUndiscoverable' => $privateRoomsUndiscoverable,
                'privateRoomsDiscoverable' => $privateRoomsDiscoverable,
                'totalRooms' => $totalRooms,
                'totalPrivateRooms' => $totalPrivateRooms,
                'publicRoomsPercent' => $publicRoomsPercent,
                'privateRoomsPercent' => $privateRoomsPercent,
                'privateRoomsDiscoverablePercent' => $privateRoomsDiscoverablePercent,
                'privateRoomsUndiscoverablePercent' => $privateRoomsUndiscoverablePercent,
                'referer' => $this->request->query->get('referer')
            )
        );
    }

    public function getRoomsInfo($type = 2, $encrypted = 0, $discoverable = null)
    {
        $roomInfo = array('nbRooms' => 0, 'nbMembers' => 0, 'averageNbMembers' => 0);

        $conn = $this->em->getConnection();
        $sql = "SELECT id 
                  FROM room 
                    WHERE 
                      room.type = ? AND 
                      room.encrypted = ? AND 
                      id != ?";

        if (!is_null($discoverable)) {
            $sql .= ' AND room.discoverable = ?';
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $type);
        $stmt->bindValue(2, $encrypted);
        $stmt->bindValue(3, self::GENERAL_ROOM_ID);

        if (!is_null($discoverable)) {
            $stmt->bindValue(4, $discoverable);
        }

        $stmt->execute();
        $rooms = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        if (is_array($rooms) && count($rooms) > 0) {

            $nbRoomUsers = $this->getNbRoomUsers($rooms);
            $roomInfo['nbRooms'] = count($rooms);
            $roomInfo['nbMembers'] = (int) $nbRoomUsers[0];
            $roomInfo['averageNbMembers'] = round((int) $nbRoomUsers[0] / count($rooms), 2);
        }

        return $roomInfo;
    }

    public function getNbRoomUsers($roomIds)
    {
        $count = 0;

        if (is_array($roomIds) && count($roomIds) > 0) {

            $conn = $this->em->getConnection();

            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder
                ->select('count(id)')
                ->from('room_user')
                ->add('where', $queryBuilder->expr()->in('room_id', ':ids'))
                ->setParameter('ids', $roomIds, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
            $count = $queryBuilder->execute()->fetchAll(\PDO::FETCH_COLUMN);
        }

        return $count;
    }

}

