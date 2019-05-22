<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

use App\Entity\User;
use App\Entity\ConferenceSessionUser;
use App\Service\Country;

class StatisticsUserController extends AdminController
{
    private $countryService;

    public function __construct(Country $country)
    {
        $this->countryService = $country;
    }

    public function listAction()
    {
        return $this->render('easy_admin/UserStatistics/list.html.twig', array());
    }

    public function showAction()
    {
        $totalActiveUsersPercent = 0;

        $totalUsers = $this->getTotalNbUsers();
        $totalActiveUsers = $this->getTotalActiveUsers();
        $totalDistinctUsersByType = $this->getTotalDistinctUsersByType();
        $usersLocation = $this->getUsersLocation();
        $usersLocationPercent = $this->getUsersLocationPercent($totalUsers, $usersLocation);
        $usersAge = $this->getUsersAge();
        $usersAgeRange = $this->getUsersAgeRange();
        $usersAgeRangePercent = $this->getUsersAgeRangePercent($totalUsers, $usersAgeRange);

        if ($totalUsers > 0 && is_array($totalActiveUsers)) {
            $totalActiveUsersPercent = number_format((int) $totalActiveUsers['total_active_users'] * 100 / (int) $totalUsers, 2, '.', '');
        }
        dump($totalActiveUsers);
        //dump($usersAgeRange);
        //dump($usersLocation);
        //dump($usersLocationPercent);
        //dump($usersAge);
        //dump($usersAgeRangePercent);

        return $this->render('easy_admin/UserStatistics/users.html.twig',
            array(
                'totalUsers' => $totalUsers,
                'totalActiveUsers' => $totalActiveUsers,
                'totalActiveUsersPercent' => $totalActiveUsersPercent,
                'totalDistinctUsersByType' => $totalDistinctUsersByType,
                'usersLocation' => $usersLocation,
                'usersLocationPercent' => $usersLocationPercent,
                'usersAge' => $usersAge,
                'usersAgeRange' => $usersAgeRange,
                'usersAgeRangePercent' => $usersAgeRangePercent,
                'referer' => $this->request->query->get('referer')
            )
        );
    }

    public function getUsersLocation()
    {
        $usersLocation = array();

        $conn = $this->em->getConnection();

        $sql = "SELECT 
                  count(*) AS nb_users, 
                  country_code
	            FROM 
	              user 
                GROUP BY country_code
                ORDER BY nb_users DESC
              ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll();

        if (is_array($users) && count($users) > 0) {
            foreach ($users as $key => $result) {

                $usersLocation[
                    $this->countryService->getCountry($result['country_code'])
                ] = (int) $result['nb_users'];
            }
        }

        return $usersLocation;
    }

    public function getUsersAge()
    {
        $usersAge = array();

        $conn = $this->em->getConnection();

        $sql = "SELECT 
                  count(*) as nb_users,
	              YEAR(NOW()) - YEAR(birth_date) as users_age
                FROM 
	              user
                GROUP BY users_age
                ORDER BY nb_users DESC
              ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll();

        if (is_array($users) && count($users) > 0) {
            foreach ($users as $key => $result) {
                $usersAge[$result['users_age']] = $result['nb_users'];
            }
        }

        return $usersAge;
    }

    public function getUsersAgeRange()
    {
        $usersAgeRange = array('18-20' => 0, '21-30' => 0, '31-40' => 0, '41-50' => 0, '51-60' => 0, '61-70' => 0, '70+' => 0);

        $conn = $this->em->getConnection();

        $sql = "SELECT agegroup, count(*) AS nb_users 
					FROM (SELECT
						  CASE 
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 18 AND 20 THEN '18-20'
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 21 and 30 THEN '21-30'
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 31 and 40 THEN '31-40'
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 41 and 50 THEN '41-50'
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 51 and 60 THEN '51-60'
						  WHEN YEAR(NOW()) - YEAR(birth_date) BETWEEN 61 and 70 THEN '61-70'
						  WHEN YEAR(NOW()) - YEAR(birth_date) > 70 THEN '70 +' 
						  END 
						  	AS agegroup
						  FROM user) 
						  user
					GROUP BY agegroup;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll();

        if (is_array($users) && count($users) > 0) {
            foreach ($users as $key => $result) {
                $usersAgeRange[$result['agegroup']] = (int) $result['nb_users'];
            }
        }

        return $usersAgeRange;
    }

    public function getTotalNbUsers()
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT 
                  count(*) as nb_users
	            FROM 
	              user
              ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetch();


        return (int) $users['nb_users'];
    }

    public function getUsersAgeRangePercent($nbUsers = 0, $ageRange = array())
    {
        $usersAgeRangePercent = array('18-20' => 0, '21-30' => 0, '31-40' => 0, '41-50' => 0, '51-60' => 0, '61-70' => 0, '70+' => 0);

        if ($nbUsers > 0 && is_array($ageRange) && count($ageRange) > 0) {
            foreach ($ageRange as $range => $nbAgeRangeUsers) {
                if ($nbAgeRangeUsers > 0) {
                    $usersAgeRangePercent[$range] = number_format((int) $nbAgeRangeUsers * 100 / (int) $nbUsers, 2, '.', '');
                }
            }
        }
        return $usersAgeRangePercent;
    }

    public function getUsersLocationPercent($nbUsers = 0, $locations = array())
    {
        $usersLocationPercent = array();

        if ($nbUsers > 0 && is_array($locations) && count($locations) > 0) {
            foreach ($locations as $country => $nbLocationUsers) {
                $usersLocationPercent[$country] = number_format((int) $nbLocationUsers * 100 / (int) $nbUsers, 2, '.', '');
            }
        }
        return $usersLocationPercent;
    }

    public function getTotalDistinctUsersByType()
    {
        $conn = $this->em->getConnection();
        $distinctUsers = array('distinct_kps' => 0, 'distinct_participants' => 0);

        $sql = "SELECT userType, count(DISTINCT(user_id)) AS nb_users
					FROM (SELECT
	    	  			    CASE 
		      				  WHEN is_kp = 1 THEN 'distinct_kps'
						      WHEN is_kp = 0 THEN 'distinct_participants'
						    END 
						  	AS userType,
						        data_start, 
					            data_end,
					            user_id
						  FROM conference_session_user
						  WHERE data_start IS NOT NULL AND data_end IS NOT NULL
						  ) 
						  conference_session_user
						  
					GROUP BY userType;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $participants = $stmt->fetchAll();

        if(is_array($participants) && count($participants) > 0) {
            foreach ($participants as $key => $users) {
                foreach ($users as $key => $value) {
                    $distinctUsers[$users['userType']] = (int) $users['nb_users'];
                }
            }
        }

        return $distinctUsers;
    }

    /*active vs inactive (at least 1 group joined and at least 1 video session joined)*/
    public function getTotalActiveUsers()
    {
        $conn = $this->em->getConnection();

        $sql = "SELECT 
                  count(DISTINCT(ru.user_id)) as total_active_users 
                FROM
                  room_user as ru
                INNER JOIN conference_session_user as csu
                ON 
                  csu.user_id = ru.user_id
                WHERE 	
                    csu.is_kp = 0 AND 
                    csu.data_start is not null and
                    csu.data_end is not null 
                ;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $activeUsers = $stmt->fetch();

        return $activeUsers;
    }
}



