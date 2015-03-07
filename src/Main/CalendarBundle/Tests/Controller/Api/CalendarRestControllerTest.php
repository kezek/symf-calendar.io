<?php

namespace Main\CalendarBundle\Tests\Controller\Api;

use Main\CalendarBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Andrei Mocanu
 */
class CalendarRestControllerTest extends WebTestCase
{
    /**
     * @test
     * @integrationTests
     */
    public function testGetEventsAction()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/events');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    /**
     * @test
     * @integrationTest
     */
    public function testPostEventAction()
    {
        //mock the EntityManager
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $client = static::createClient();
        $client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManager);

        $client->request('POST', '/api/v1/events', array('title' => 'TEST', 'date' => '2015-01-01'));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    /**
     * @test
     * @integrationTest
     */
    public function testPutEventAction()
    {
        //mock the EntityManager
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $metadataFactory = $this->getMockBuilder('\Doctrine\Common\Persistence\Mapping\ClassMetadataFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())->method('getMetadataFactory')->willReturn($metadataFactory);
        $event = $this->getMock(Event::class);

        $eventRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $eventRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($event));
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($eventRepository));

        $client = static::createClient();
        $client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManager);

        $client->request('PUT', '/api/v1/events/1', array('title' => 'TEST2', 'date' => '2015-02-02'));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    /**
     * @test
     * @integrationTest
     */
    public function testDeleteEventAction()
    {
        //mock the EntityManager
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $metadataFactory = $this->getMockBuilder('\Doctrine\Common\Persistence\Mapping\ClassMetadataFactory')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())->method('getMetadataFactory')->willReturn($metadataFactory);
        $event = $this->getMock(Event::class);

        $eventRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $eventRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($event));
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($eventRepository));

        $client = static::createClient();
        $client->getContainer()->set('doctrine.orm.default_entity_manager', $entityManager);

        $client->request('DELETE', '/api/v1/events/1');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}