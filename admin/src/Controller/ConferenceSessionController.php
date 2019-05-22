<?php
namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

use Doctrine\ORM\Query\ResultSetMapping;
use App\Service\Country;
use App\Service\ModerationLog;

use App\Entity\User;
use App\Entity\Moderation;
use App\Entity\ConferenceSession;
use App\Entity\ConferenceSessionUser;

class ConferenceSessionController extends BaseAdminController
{
    public function __construct() {

    }

    public function showAction()
    {

        $this->dispatch(EasyAdminEvents::PRE_SHOW);

        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');

        $entity = $easyadmin['item'];

        $sessionParticipants = $this->getSessionParticipantsInfo($entity->getRef());

        $fields = $this->entity['show']['fields'];
        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $this->dispatch(EasyAdminEvents::POST_SHOW, array(
            'deleteForm' => $deleteForm,
            'fields' => $fields,
            'entity' => $entity,
        ));

        $parameters = array(
            'participants' => $sessionParticipants,
            'entity' => $entity,
            'fields' => $fields,
            'delete_form' => $deleteForm->createView(),
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('show', $this->entity['templates']['show'], $parameters));
    }

    public function getSessionParticipantsInfo($sessionRef)
    {
        $participants = array();

        $conferencesRepository = $this->em->getRepository(ConferenceSessionUser::class);
        $conferenceParticipants = $conferencesRepository->findBy(
                array('conferenceSessionId' => $sessionRef),
                array('isKp' => 'DESC')
            );

        //dump($conferenceParticipants);

        if(count($conferenceParticipants) > 0) {

            foreach ($conferenceParticipants as $key => $participant) {

                $participants[$participant->getUserId()]['isKp'] = $participant->getIsKp();
                $participants[$participant->getUserId()]['dataStart'] = $participant->getDataStart();
                $participants[$participant->getUserId()]['dataEnd'] = $participant->getDataEnd();
                $participants[$participant->getUserId()]['duration'] = $participant->getDuration();
                $participants[$participant->getUserId()]['costEth'] = $participant->getCostEth() / 10 ** 18;
                $participants[$participant->getUserId()]['costUsd'] = $participant->getCostUsd();
                $participants[$participant->getUserId()]['email'] = $participant->getUser()->getEmail();
            }
        }

        return $participants;
    }

}