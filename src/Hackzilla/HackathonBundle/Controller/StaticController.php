<?php

namespace Hackzilla\HackathonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hackzilla\HackathonBundle\Entity\Event;

class StaticController extends Controller
{
    /**
     *
     */
    public function homepageAction()
    {
        $this->logEvent();
        return $this->render('HackzillaHackathonBundle:Static:homepage.html.twig', array(
        ));
    }

    /**
     *
     */
    public function aboutAction()
    {
        $this->logEvent();
        return $this->render('HackzillaHackathonBundle:Static:about.html.twig', array(
        ));
    }

    /**
     *
     */
    public function contactAction()
    {
        $this->logEvent();
        
        $eventRepository = $this->getDoctrine()->getRepository("HackzillaHackathonBundle:Event");
        
        return $this->render('HackzillaHackathonBundle:Static:contact.html.twig', array(
            'showPhonenumber' => ($eventRepository->matchCallback($_SERVER['REMOTE_ADDR'])),
        ));
    }

    private function logEvent()
    {
        if (0) {
            $em = $this->getDoctrine()->getEntityManager();

            $event = new Event();
            $event->setIp($_SERVER['REMOTE_ADDR']);
            $event->setPath($_SERVER['REQUEST_URI']);

            $em->persist($event);
            $em->flush();
        } else {
            $pusher_appId = $this->container->getParameter('pusher.app_id');
            $pusher_key = $this->container->getParameter('pusher.key');
            $pusher_secret = $this->container->getParameter('pusher.secret');
            $pusher_channel = $this->container->getParameter('pusher.channel');
            $pusher_eventName = $this->container->getParameter('pusher.event_name');

            $path = explode('/',$this->getRequest()->getRequestUri());
            $path = array_pop($path);

            $pusher = new \Pusher($pusher_key, $pusher_secret, $pusher_appId);
            $pusher->trigger(array($pusher_channel), $pusher_eventName, array('ip'=>$_SERVER['REMOTE_ADDR'], 'data'=>
                array(
                    'manufacturer' => 'site',
                    'model' => $path,
                    'variant_name' => $path,
                ),
                'type'=> 'variant'));
        }
    }
    
    
    /**
     *
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $CallLogs = $em->getRepository('HackzillaHackathonBundle:CallLog')->findAll();
        $CallBacks = $em->getRepository('HackzillaHackathonBundle:CallBack')->findAll();

        return $this->render('HackzillaHackathonBundle:Static:admin.html.twig', array(
            'CallBacks' => $CallBacks,
            'CallLogs'  => $CallLogs,
        ));
    }
}