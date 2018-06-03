<?php 

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Event;


class EventController extends AbstractController
{

	/**
	*@Route("/events", name="events_list")
	*/
	public function indexAction()
	{
		$events = $this->getDoctrine()
		->getManager()
		->getRepository(Event::class)
		->findAll();

		return $this->render('events/index.html.twig', compact('events'));
	}

	/**
	*@Route("/events/{id}", name="event_details")
	*/
	public function showAction(Event $event)
	{

		return $this->render('events/show.html.twig', compact('event'));
	}
	
	
}
