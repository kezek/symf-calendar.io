<?php

namespace Main\CalendarBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use DateTime;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Main\CalendarBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * REST controller for Calendar
 *
 * @author Andrei Mocanu
 */
class CalendarRestController extends Controller
{
    /**
     * @ApiDoc(
     *  description="GET Events",
     *  output="array<Main\CalendarBundle\Entity\Event>",
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Internal server error",
     *  }
     *  )
     * @Rest\Get(path="/events")
     *
     * @QueryParam(name="start", nullable=false)
     * @QueryParam(name="end", nullable=false)
     * @param ParamFetcherInterface $paramFetcher
     * @return string
     */
    public function getEventsAction(ParamFetcherInterface $paramFetcher)
    {
        return new Response($this->get('serializer')->serialize($this->getDoctrine()->getManager()->getRepository(Event::class)->findAllBetweenDates(
            /*
             * @todo ParamConverter doesn't seem to work with @QueryParam,
             * needs more research in order to avoid creating DateTimes in controller layer
             */
            new DateTime($paramFetcher->get('start')),
            new DateTime($paramFetcher->get('end')))
        , 'json'));
    }

    /**
     * @ApiDoc(
     *  description="Create new Event",
     *  input="Main\CalendarBundle\Entity\Event",
     *  output="Main\CalendarBundle\Entity\Event",
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Internal server error",
     *  }
     *  )
     *
     * @param Request $request
     * @return Response
     */
    public function postEventAction(Request $request)
    {
        $event = new Event();
        $event->dataSetter($request->request->all());
        $this->getDoctrine()->getManager()->persist($event);
        $this->getDoctrine()->getManager()->flush($event);

        return new Response($this->get('serializer')->serialize($event, 'json'));
    }

    /**
     * @ApiDoc(
     *  description="Edit Event",
     *  input="Main\CalendarBundle\Entity\Event",
     *  output="Main\CalendarBundle\Entity\Event",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Event not found",
     *         500="Internal server error",
     *  }
     * )
     *
     * @Rest\Put(path="/events/{event}", defaults={"event" : null})
     * @param Request $request
     * @param Event $event Event Id
     * @return Response
     */
    public function putEventAction(Request $request, Event $event)
    {
        $event->dataSetter($request->request->all());

        $this->getDoctrine()->getManager()->flush($event);

        return new Response($this->get('serializer')->serialize($event, 'json'));
    }

    /**
     * @ApiDoc(
     *  description="Delete Event",
     *  input="Main\CalendarBundle\Entity\Event",
     *  output="Main\CalendarBundle\Entity\Event",
     *  statusCodes={
     *         204="Returned when successful",
     *         404="Event not found",
     *         500="Internal server error",
     *  }
     * )
     *
     * @Rest\Delete(path="/events/{event}", defaults={"event" : null})
     * @param Event $event event id
     * @return Response
     */
    public function deleteEventAction(Event $event)
    {
        $this->getDoctrine()->getManager()->remove($event);
        $this->getDoctrine()->getManager()->flush($event);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

}