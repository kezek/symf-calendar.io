<?php

namespace Main\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Front Controller
 *
 * @author Andrei Mocanu
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('MainCalendarBundle:Default:index.html.twig');
    }
}
