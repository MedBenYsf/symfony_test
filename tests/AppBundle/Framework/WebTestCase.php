<?php 

namespace Tests\AppBundle\Framework;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use AppBundle\Entity\Event;
use Doctrine\ORM\Tools\SchemaTool;


class WebTestCase extends BaseWebTestCase
{
	protected $client;
	protected $container;
	protected $em;
	protected $crawler;
	protected $response;
	protected $responseContent;

	protected function setUp()
	{
		parent::setUp();
		$this->client = static::createClient();

		$this->container = $this->client->getContainer();

		$this->em = $this->container->get('doctrine')->getManager();

		static $metadata = null;

		if (!$metadata) {
			$metadata = $this->em->getMetadataFactory()->getAllMetadata();
		}
		$schemaTool = new SchemaTool($this->em);
		$schemaTool->dropDatabase();
		
		if (!empty($metadata)) {
			$schemaTool->createSchema($metadata);
		}

	}

	public function visit($url)
	{
		$this->crawler = $this->client->request('GET', $url);
		$this->response = $this->client->getResponse();
		$this->responseContent = $this->response->getContent();
		return $this;
	}

	public function seeText($text)
	{
		$this->assertContains($text, $this->responseContent);
		return $this;

	}

	public function assertResponseOk()
	{
		$this->assertEquals(200, $this->response->getStatusCode());
		return $this;
	}


	protected function onNotSuccessfulTest(\Throwable $t)
    {
    	if ($this->crawler && 
    		$this->crawler->filter('.exception-message')->count() > 0  ) {

    		$throwableClass = get_class($t);
    		throw new $throwableClass($t->getMessage().'|'.$this->crawler->filter('.exception-message')->eq(0)->text());
    	}
    	
    	
        throw $t;
    }

	protected function tearDown()
	{
		parent::tearDown();
		$this->em->close();
		$this->em = null;
		
	}
	
	
}