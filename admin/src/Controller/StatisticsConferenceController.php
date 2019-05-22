<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

use App\Entity\ConferenceSession;
use App\Entity\ConferenceSessionUser;
use App\Service\Country;

class StatisticsConferenceController extends AdminController
{
    private $countryService;

    public function __construct(Country $country)
    {
        $this->countryService = $country;
    }

    public function listAction()
    {
        return $this->render('easy_admin/ConferenceStatistics/list.html.twig', array());
    }

    public function showAction()
    {
        $conferencesInfo['averageParticipants'] = 0;
        $conferencesInfo['averageDuration'] = 0;
        $conferencesInfo['averageKpRevenue'] = 0;
        $conferencesInfo['averageParticipantsPaymentsEth'] = 0;

        $conferencesTimeGrid = array();
        $formatedConferencesTimeGrid = array();
        $participantsLocation = array();
        $kpsLocation = array();

        $conferencesInfo = $this->getConferencesInfo();
        $totalConferencesParticipants = $this->getTotalParticipants();

        if ($conferencesInfo['totalConferences'] > 0) {

            if($totalConferencesParticipants['total_participants'] > 0) {
                $conferencesInfo['averageParticipants'] =
                    number_format($totalConferencesParticipants['total_participants'] / $conferencesInfo['totalConferences'], 2, '.', '');
            }

            if($conferencesInfo['totalConferencesDuration'] > 0) {
                $conferencesInfo['averageDuration'] =
                    round($conferencesInfo['totalConferencesDuration'] / $conferencesInfo['totalConferences']);
            }

            if($conferencesInfo['totalKpsRevenue'] > 0) {
                $conferencesInfo['averageKpRevenue'] =
                    round($conferencesInfo['totalKpsRevenue'] / $conferencesInfo['totalConferences']);
            }

            if(is_array($totalConferencesParticipants) && count($totalConferencesParticipants) > 0 && (int) $totalConferencesParticipants['total_payments_participants'] > 0) {
                $conferencesInfo['averageParticipantsPaymentsEth'] =
                    round($totalConferencesParticipants['total_payments_participants'] / $conferencesInfo['totalConferences']);
            }

            $conferencesTimeGrid = $this->getConferenceTimeGrid();
            $formatedConferencesTimeGrid = $this->formatConferencesTimeGrid($conferencesTimeGrid);
            $participantsLocation = $this->getParticipantsLocation();
            $kpsLocation = $this->getParticipantsLocation(true);
        }

        return $this->render('easy_admin/ConferenceStatistics/conferences.html.twig',
            array(
                'totalConferences' => $conferencesInfo['totalConferences'],
                'totalConferencesDuration' => gmdate('H:i:s', $conferencesInfo['totalConferencesDuration']),
                'totalKpsRevenueEth' => $conferencesInfo['totalKpsRevenue'] / 10 ** 18,
                'totalParticipants' => $totalConferencesParticipants['total_participants'],
                'totalParticipantsPaymentsEth' => $totalConferencesParticipants['total_payments_participants'] / 10 ** 18,
                'averageParticipants' => $conferencesInfo['averageParticipants'],
                'averageDuration' => gmdate('H:i:s',$conferencesInfo['averageDuration']),
                'averageKpRevenue' => $conferencesInfo['averageKpRevenue'] / 10 ** 18,
                'averageParticipantsPaymentsEth' => $conferencesInfo['averageParticipantsPaymentsEth']  / 10 ** 18,
                'conferencesTimeGrid' => $formatedConferencesTimeGrid,
                'participantsLocation' => $participantsLocation,
                'kpsLocation' => $kpsLocation,
                'referer' => $this->request->query->get('referer')
            )
        );
    }

    public function getConferencesInfo()
    {
        $conn = $this->em->getConnection();

        $sql = "select 
	              count(*) as total_closed_sessions, 
	              SUM(duration) as kp_total_duration,
	              SUM(cost_eth)  as kp_eth_revenue
            	from 
		          conference_session_user
	            where 
	              is_kp = 1 AND
	              data_end is not null AND
	              data_end is not null
                ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $conferences = $stmt->fetch();

        $conferencesInfo['totalConferences'] = (int) $conferences['total_closed_sessions'];
        $conferencesInfo['totalConferencesDuration'] = (int) $conferences['kp_total_duration'];
        $conferencesInfo['totalKpsRevenue'] = (int) $conferences['kp_eth_revenue'];

        return $conferencesInfo;
    }

    public function getTotalParticipants()
    {
        $conn = $this->em->getConnection();

        $sql = "select
                 count(*) as total_participants,
                sum(cost_eth) as total_payments_participants       
                from
                  conference_session_user                  
                where
                  is_kp = 0 AND
                  data_end is not null AND
                  data_end is not null
                ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $participants = $stmt->fetch();

        return $participants;
    }

    public function getConferenceTimeGrid()
    {
        $timeGrid = array();
        $conn = $this->em->getConnection();

        $sql = "select
                  count(*) as nb_conferences,
                  DAYNAME(ANY_VALUE(data_start)) as day_name,
                  HOUR(data_start) as conference_hour_start
                from
                  conference_session_user
                where
                  is_kp = 1 AND
                  data_end is not null AND
                  data_end is not null
                GROUP BY
                  DAYNAME(data_start),
                  HOUR(data_start)
                ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $conferencesTimeGrid = $stmt->fetchAll();

        if (is_array($conferencesTimeGrid) && count($conferencesTimeGrid) > 0) {
            foreach ($conferencesTimeGrid as $key => $result) {
                $timeGrid[$result['day_name']][$result['conference_hour_start']] = $result['nb_conferences'];
            }
        }

        return $timeGrid;


        return $conferencesTimeGrid;
    }

    public function formatConferencesTimeGrid($conferencesTimeGrid = array())
    {
        $timeGrid = array(
            'Monday' => array(),
            'Tuesday' => array(),
            'Wednesday' => array(),
            'Thursday' => array(),
            'Friday' => array(),
            'Saturday' => array(),
            'Sunday' => array()
        );

        foreach ($timeGrid as $key => $value) {
            for ($i = 0; $i <= 23; $i++) {
                $timeGrid[$key][$i] = 0;

            }
        }

        if (is_array($conferencesTimeGrid) && count($conferencesTimeGrid) > 0) {
            foreach ($conferencesTimeGrid as $day => $hours) {
                foreach ($hours as $key => $value) {
                    $timeGrid[$day][$key] = $value;
                }
            }
        }
        return $timeGrid;
    }

    public function getParticipantsLocation($isKp = false)
    {
        $participantsLocation = array();

        $conn = $this->em->getConnection();

        $sql = "SELECT 
                    count(DISTINCT(csu.user_id)) as nb_participants, 
                    u.country_code
	              FROM  
	                user u
                  INNER JOIN 
	                conference_session_user csu
                  ON 
                    csu.user_id = u.id
                  WHERE 
                      csu.is_kp = " . (int) $isKp . "
                  AND csu.data_start IS NOT NULL
                  AND csu.data_END IS NOT NULL      
                  GROUP BY
                    country_code
                  ORDER BY  
                    nb_participants DESC
                ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $participants = $stmt->fetchAll();

        if (is_array($participants) && count($participants) > 0) {
            foreach ($participants as $key => $result) {

                $participantsLocation[
                    $this->countryService->getCountry($result['country_code'])
                ] = $result['nb_participants'];
            }
        }

        return $participantsLocation;
    }
}


