<?php

namespace Hackzilla\HackathonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Hackzilla\HackathonBundle\Entity\Action;

class PusherController extends Controller
{
    public function loopAction()
    {
        return $this->render('HackzillaHackathonBundle:Pusher:loop.html.twig', array(
            'pusher_key' => $this->container->getParameter('pusher.key'),
            'pusher_channel' => $this->container->getParameter('pusher.channel'),
            'pusher_eventName' => $this->container->getParameter('pusher.event_name'),
        ));
    }
    
    public function askForAssistanceAction()
    {
        $payload = $this->getRequest()->request->all();

        sleep(1);

        $pusher_appId = $this->container->getParameter('pusher.app_id');
        $pusher_key = $this->container->getParameter('pusher.key');
        $pusher_secret = $this->container->getParameter('pusher.secret');
        $pusher_channel = $this->container->getParameter('pusher.channel');
        $pusher_actionName = $this->container->getParameter('pusher.action_name');
        
        $pusher = new \Pusher($pusher_key, $pusher_secret, $pusher_appId);
        $pusher->trigger(array($pusher_channel), $pusher_actionName, $payload);

        $response = new Response('triggered with'.print_r($payload, true));

        $response->setStatusCode(200);
        
        return $response;
    }

    // recieve events
    public function indexAction()
    {
        $ip = $this->getRequest()->query->get('ip');
        $pin = $this->getRequest()->query->get('pin');
        $model = $this->getRequest()->query->get('model');
        $manufacturer = $this->getRequest()->query->get('manufacturer');
        $variant = $this->getRequest()->query->get('variant');
        $requestCall = $this->getRequest()->query->get('requestCall', 0);

        $event = new Action();
        $event->setPin($pin);
        $event->setIp($ip);
        $event->setModel($model);
        $event->setManufacturer($manufacturer);
        $event->setVariant($variant);
        $event->setRequestCall($requestCall);
        die;
    }
}
