<?php 

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\Framework\WebTestCase;
use AppBundle\Entity\Event;

class EventControllerTest extends WebTestCase
{

	/**
	*@test
	*/
	public function index_should_show_all_events()
	{
		
		$event1 = new Event();
		$event1->setName('Symfony conference');
		$event1->setLocation('Paris, FR');
		$event1->setPrice(25);

		$event2 = new Event();
		$event2->setName('Laravel conference');
		$event2->setLocation('Rabat, MA');
		$event2->setPrice(0);

		$event3 = new Event();
		$event3->setName('Spring conference');
		$event3->setLocation('Paris, FR');
		$event3->setPrice(30);

		$this->em->persist($event1);
		$this->em->persist($event2);
		$this->em->persist($event3);
		$this->em->flush();

		$this->visit('/events')
			 ->assertResponseOk()
			 ->seeText($event1->getName())
			 ->seeText($event2->getName())
			 ->seeText($event3->getName())
			 ;

	}

	/**
	*@test
	*/
	public function shouldTrue()
	{
		$this->assertTrue(true);

	}
	
	
}